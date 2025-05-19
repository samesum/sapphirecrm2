<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->invoice_server_side($request->project_id, $request->customSearch, $request->date_range);
        }

        $page_data['invoices'] = Invoice::get();
        return view('projects.invoice.index', $page_data);
    }

    public function create()
    {
        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        return view('projects.invoice.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'payment_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        
        $user_id = Auth::user()->id;
        

        $data['project_id']     = $request->project_id;
        $data['user_id']        = $user_id;
        $data['due_date']       = date('Y-m-d H:i:s', strtotime($request->due_date));
        $data['title']          = $request->title;
        $data['payment']        = $request->payment;
        $data['payment_status'] = $request->payment_status;

        Invoice::insert($data);
        return response()->json([
            'success' => 'Invoice Created.',
        ]);
    }

    public function delete($id)
    {
        Invoice::where('id', $id)->delete();
        return response()->json([
            'success' => 'Invoice Deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $data['invoice'] = Invoice::where('id', $id)->first();
        return view('projects.invoice.edit', $data);
    }

    public function view($id)
    {
        $data['invoice'] = Invoice::where('id', $id)->first();
        return view('projects.invoice.view', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'payment_status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data['title']   = $request->title;
        $data['payment'] = $request->payment;
        $data['payment_status'] = $request->payment_status;
        $data['due_date'] = $request->due_date;

        Invoice::where('id', $id)->update($data);

        return response()->json([
            'success' => 'Invoice Updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Invoice::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Invoices Deleted.']);
        }

        return response()->json(['error' => 'No invoices selected for deletion.'], 400);
    }

    public function payout($id)
    {
        $invoice         = Invoice::where('id', $id)->first();
        $payment_purpose = DB::table('payment_purposes')->where('title', 'invoice')->first();
        $project   = Project::where('id', $invoice->project_id)->first();
        $user_email    = User::where('id', $project->client_id)->value('email');
        $items[]         = [
            'id'           => $invoice->id,
            'title'        => $invoice->title,
            'price'        => $invoice->payment,
            'project_code' => $project->code,
            'user_email' => $user_email,
        ];

        $payment_details = [
            'items'           => $items,

            'custom_field'    => [
                'item_type'  => $payment_purpose->title,
                'pay_for'    => $payment_purpose->pay_for,
                'user_id'    => Auth::user()->id,
                'user_photo' => Auth::user()->photo,
            ],

            'success_method'  => [
                'model_name'    => $payment_purpose->model,
                'function_name' => $payment_purpose->function_name,
            ],

            'payable_amount'  => $invoice->payment,
            'payment_purpose' => $payment_purpose->id,
            'cancel_url'      => route(get_current_user_role() . '.project.details', [$project->code, 'invoice']),
            'success_url'     => route('payment.success', ''),
        ];

        Session::put(['payment_details' => $payment_details]);
        return redirect()->route('payment');
    }

    public function exportFile(Request $request, $file, $code) {

        $query = Invoice::query();

        $ids = $request->input('selectedIds'); // e.g. "[1,2,3]"
        if (!empty($ids) && $ids != '[]') {
            $idsArray = json_decode($ids, true); // convert to array
            if (is_array($idsArray)) {
                $query->whereIn('id', $idsArray);
            }
        }

        $query->where('project_id', project_id_by_code($code));

        if (isset($request->customSearch)) {
            $string = $request->customSearch;
            $query->where(function ($q) use ($string) {
                $q->where('title', 'like', "%{$string}%");
            });
        }

        if ($request->date) {
            $start_date     = date('Y-m-d', strtotime($request->date));
            $query->whereDate('timestamp_start', $start_date);
        }
    
        $page_data['invoices'] = count($request->all()) > 0 ? $query->get() : Invoice::where('project_id', project_id_by_code($code))->get();

        if ($file == 'pdf') {
            $pdf = FacadePdf::loadView('projects.invoice.pdf', $page_data);
            return $pdf->download('invoice.pdf');
        }
        if ($file == 'print') {
            $pdf = FacadePdf::loadView('projects.invoice.pdf', $page_data);
            return $pdf->stream('invoice.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'invoice.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $users = count($request->all()) > 0 ? $query->get() : Invoice::where('project_id', project_id_by_code($code))->get();
    
            $columns = ['#', 'title', 'payment', 'status', 'due_date'];
            
            $callback = function() use ($columns, $users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                $count = 1;
                foreach ($users as $item) {    
                    fputcsv($file, [
                        $count,
                        $item->title,
                        currency($item->payment),
                        $item->payment_status,
                        date('d M Y h:i A', strtotime($item->due_date))
                    ]);
                    $count++;
                }
    
                fclose($file);
            };
    
            return response()->stream($callback, 200, $headers);
        }
    
        // If no valid file type was provided
        return response()->json(['error' => 'Invalid file type'], 400);
    }

}
