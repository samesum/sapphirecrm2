<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use App\Models\Invoice;
use App\Models\offlinePayment as OfflinePayment;
use App\Models\Payment_history;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class OfflinePaymentController extends Controller
{
    public function store(Request $request)
    {
        // check amount
        $payment_details = Session::get('payment_details');

        $item_id_arr = [];
        foreach ($payment_details['items'] as $item) {
            $item_id_arr[] = $item['id'];
        }

        $rules = [
            'doc' => 'required|mimes:jpeg,jpg,pdf,txt,png,docx,doc|max:3072',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('doc');

        $offline_payment['user_id']         = Auth::user()->id;
        $offline_payment['item_type']       = $payment_details['custom_field']['item_type'];
        $offline_payment['items']           = json_encode($item_id_arr);
        $offline_payment['total_amount']    = $payment_details['payable_amount'];
        $offline_payment['doc']             = FileUploader::upload($file, 'offline_payment', null, null, 300);
        $offline_payment['payment_purpose'] = $payment_details['payment_purpose'];
        $offline_payment['phone_no']        = $request->phone_no;
        $offline_payment['bank_no']         = $request->bank_no;

        OfflinePayment::insert($offline_payment);

        // return to courses
        Session::flash('success', get_phrase('The payment will be completed once the admin reviews and approves it.'));
        return redirect()->route(get_current_user_role() . '.project.details', [$payment_details['items'][0]['project_code'], 'invoice']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->offline_payments_server_side($request->customSearch, $request->status, $request->user, $request->date_range, $request->minPrice, $request->maxPrice);
        }

        $page_data['users']    = User::get();
        $page_data['payments'] = OfflinePayment::get();
        return view('offline_payments.index', $page_data);
    }

    public function download_doc($id)
    {
        // validate id
        if (empty($id)) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // payment details
        $payment_details = OfflinePayment::where('id', $id)->first();
        $file_path       = public_path($payment_details->doc);
        if (!file_exists($file_path)) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }
        // download file
        return Response::download($file_path);
    }

    public function accept_payment($id)
    {
      
        // validate id
        if (empty($id)) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $payment_details = OfflinePayment::where('id', $id)->first();

        $item = str_replace('[','',$payment_details['items']);
        $item = str_replace(']','',$item);
        $project_code = Project::where('id', $item)->value('code');

        $payment['user_id']         = $payment_details['user_id'];
        $payment['payment_type']    = 'offline';
        $payment['payment_purpose'] = $payment_details['payment_purpose'];
        $payment['project_code']    = $project_code;
        $payment['date_added']      = time();

        if ($payment_details->item_type == 'invoice') {
            $items = json_decode($payment_details->items);
            foreach ($items as $item) {
                if ($payment_details->item_type == 'invoice') {
                    $invoice               = Invoice::where('id', $item)->first();
                    if($invoice){
                        $payment['invoice_id'] = $invoice->id;
                        $payment['amount']     = $invoice->payment;

                        Payment_history::insert($payment);
                    }
                }
            }
        }

        OfflinePayment::where('id', $id)->update(['status' => 1]);

        // go back
        Session::flash('success', 'Payment has been accepted.');
        return redirect()->route('admin.offline.payments');
    }

    public function decline_payment($id)
    {
        // remove items from offline payment
        OfflinePayment::where('id', $id)->update(['status' => 2]);

        Session::flash('success', 'Payment has been suspended');
        return redirect()->route('admin.offline.payments');
    }

    public function success_login()
    {
        return view('smtp.success_login');
    }
    public function payment()
    {
        return view('smtp.payment');
    }
    public function invoice()
    {
        return view('smtp.invoice');
    }
    public function confirm_email()
    {
        return view('smtp.confirm_email');
    }
    public function verify_email()
    {
        return view('smtp.verify_email');
    }

    public function ExportFile(Request $request, $file)
    {
        $query = OfflinePayment::query();

        $ids = $request->input('selectedIds'); // e.g. "[1,2,3]"
        if (!empty($ids) && $ids != '[]') {
            $idsArray = json_decode($ids, true); // convert to array
            if (is_array($idsArray)) {
                $query->whereIn('id', $idsArray);
            }
        }

        // Custom search
        if (!empty($request->customSearch)) {
            $string = $request->customSearch;
            $query->whereHas('user', function ($userQuery) use ($string) {
                $userQuery->where('name', 'like', "%{$string}%");
            });
        }

        // Min & Max Price Filter
        $maxPrice = (int) str_replace('$', '', $request->maxPrice);
        $minPrice = (int) str_replace('$', '', $request->minPrice);
        if ($minPrice > 0 || $maxPrice > 0) {
            $query->whereBetween('total_amount', [
                $minPrice > 0 ? $minPrice : 0,
                $maxPrice > 0 ? $maxPrice : PHP_INT_MAX
            ]);
        }

        // Status Filter
        if (!empty($request->status) && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // User Filter
        if (!empty($request->user) && $request->user != 'all') {
            $query->where('user_id', $request->user);
        }

        // Start Date Filter
        if (!empty($request->start_date)) {
            $start_date = date('Y-m-d', strtotime($request->start_date));
            $query->whereDate("created_at", $start_date);
        }

        // Fetch data
        $payments = $query->count() > 0 ? $query->get() : OfflinePayment::get();

        // PDF Export
        if ($file == 'pdf') {
            $pdf = FacadePdf::loadView('offline_payments.pdf', ['payments' => $payments]);
            return $pdf->download('offline_payments.pdf');
        }

        // Print View
        if ($file == 'print') {
            $pdf = FacadePdf::loadView('offline_payments.pdf', ['payments' => $payments]);
            return $pdf->stream('offline_payments.pdf');
        }

        // CSV Export
        if ($file == 'csv') {
            $fileName = 'offline_payments.csv';
            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];

            $columns = ['#', 'user_name', 'payment_type', 'amount', 'purpose', 'phone', 'bank', 'status', 'date_added'];

            $callback = function () use ($columns, $payments) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                $statuses = [
                    1 => get_phrase('Accepted'),
                    2 => get_phrase('Suspended'),
                    0 => get_phrase('Pending'),
                ];

                $count = 1;
                foreach ($payments as $item) {
                    fputcsv($file, [
                        $count,
                        $item->user->name ?? 'N/A',
                        $item->item_type,
                        currency($item->total_amount),
                        $item->invoice->title ?? 'N/A',
                        $item->phone_no,
                        $item->bank_no,
                        $statuses[$item->status] ?? 'Unknown',
                        date('d M Y h:i A', strtotime($item->created_at))
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
