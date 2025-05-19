<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class TimesheetController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            return app(ServerSideDataController::class)->timesheet_server_side($request->project_id, $request->customSearch, $request->date_range, $request->user);                
        }
        $page_data['timesheets'] = Timesheet::get();
        $page_data['users'] = User::get();
        return view('projects.timesheet.index', $page_data);
    }
    public function create()
    {
        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        $page_data['user_id']    = get_current_user_role();
        $page_data['staffs'] = User::where('role_id', 3)->get();
        return view('projects.timesheet.create', $page_data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'staff' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data['project_id']      = $request->project_id;
        $data['user_id']         = Auth::user()->id;
        $data['staff']            = $request->staff;
        $data['title']           = $request->title;

        $date_range_arr = explode(' - ', $request->dateTimeRange);
        $data['timestamp_start'] = $date_range_arr[0];
        $data['timestamp_end']   = $date_range_arr[1];

        Timesheet::insert($data);
        return response()->json([
            'success' => 'Timesheet Created.',
        ]);
    }

    public function delete($id)
    {
        Timesheet::where('id', $id)->delete();
        return response()->json([
            'success' => 'Timesheet Deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {
        $page_data['staffs'] = User::where('role_id', 3)->get();
        $page_data['timesheet'] = Timesheet::where('id', $id)->first();
        return view('projects.timesheet.edit', $page_data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'staff' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data['title']           = $request->title;
        $data['staff']            = $request->staff;
        
        $date_range_arr = explode(' - ', $request->dateTimeRange);
        $data['timestamp_start'] = $date_range_arr[0];
        $data['timestamp_end']   = $date_range_arr[1];

        Timesheet::where('id', $id)->update($data);

        return response()->json([
            'success' => 'Timesheet Updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Timesheet::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Timesheets Deleted.']);
        }

        return response()->json(['error' => 'No timesheets selected for deletion.'], 400);
    }

    public function exportFile(Request $request, $file, $code) {

        $query = Timesheet::query();

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

        if ($request->start_date && $request->end_date) {
            $start_date     = date('Y-m-d H:i:s', strtotime($request->start_date));
            $end_date       = date('Y-m-d H:i:s', strtotime($request->end_date));
            $query->where(function ($q) use ($start_date, $end_date) {
                $q->where('timestamp_start', '>=', $start_date);
                $q->where('timestamp_end', '<=', $end_date);
            });
        }
        
        if ($request->user && $request->user != 'all') {
            $user = $request->user;
            $query->where(function ($q) use ($user) {
                $q->where('user_id', $user);
            });
        }

        $page_data['timesheets'] = count($request->all()) > 0 ? $query->get() : Timesheet::where('project_id', project_id_by_code($code))->get();

        if ($file == 'pdf') {
            $pdf = FacadePdf::loadView('projects.timesheet.pdf', $page_data);
            return $pdf->download('timesheet.pdf');
        }
        if ($file == 'print') {
            $pdf = FacadePdf::loadView('projects.timesheet.pdf', $page_data);
            return $pdf->stream('timesheet.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'timesheet.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $timesheets = count($request->all()) > 0 ? $query->get() : Timesheet::where('project_id', project_id_by_code($code))->get();
    
            $columns = ['#', 'title', 'user', 'staff', 'start_date', 'end_date'];
            
            $callback = function() use ($columns, $timesheets) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                $count = 1;
                foreach ($timesheets as $item) {    
                    fputcsv($file, [
                        $count,
                        $item->title,
                        User::where('id', $item->user_id)->first()->name,
                        User::where('id', $item->staff)->first()->name,
                        date('d M Y h:i A', strtotime($item->timestamp_start)),
                        date('d M Y h:i A', strtotime($item->timestamp_end))
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
