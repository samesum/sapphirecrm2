<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class MilestoneController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->milestone_server_side($request->project_id, $request->customSearch, $request->task, $request->date_range);
        }

        $page_data['milestones'] = Milestone::get();

        return view('projects.milestone.index', $page_data);
    }

    public function create()
    {
        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        return view('projects.milestone.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'tasks' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $data['project_id']  = $request->project_id;
        $data['title']       = $request->title;
        $data['description'] = $request->description;
        $data['progress']       = $request->progress;
        $data['tasks']       = json_encode($request->tasks);

        Milestone::insert($data);
        return response()->json([
            'success' => 'Milestone Created.',
        ]);
    }

    public function delete($id)
    {
        Milestone::where('id', $id)->delete();
        return response()->json([
            'success' => 'Milestone Deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {

        $data['milestone'] = Milestone::where('id', $id)->first();
        return view('projects.milestone.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'tasks' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $project['title'] = $request->title;
        $project['description'] = $request->description;
        $project['progress']       = $request->progress;
        $project['tasks']       = json_encode($request->tasks);

        Milestone::where('id', $id)->update($project);

        return response()->json([
            'success' => 'Milestone Updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            Milestone::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Milestone Deleted.']);
        }

        return response()->json(['error' => 'No milestone selected for deletion.'], 400);
    }

    public function show($id)
    {
        $milestone          = Milestone::where('id', $id)->first();
        $task_id            = $milestone->tasks ? json_decode($milestone->tasks) : [];
        $page_data['tasks'] = Task::whereIn('id', $task_id)->get();

        return view('projects.milestone.tasks', $page_data);
    }

    public function exportFile(Request $request, $file, $code) {

        $query = Milestone::query();

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

        if ($request->task && $request->task != 'all') {
            $task           = json_encode($request->task);
            $task           = str_replace('[', '', $task);
            $task           = str_replace(']', '', $task);
            $query->where(function ($q) use ($task) {
                $q->where('tasks', 'like', "%{$task}%");
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

        $page_data['milestones'] = count($request->all()) > 0 ? $query->get() : Milestone::where('project_id', project_id_by_code($code))->get();
        
        if ($file == 'pdf') {
            $pdf = FacadePdf::loadView('projects.milestone.pdf', $page_data);
            return $pdf->download('milestone.pdf');
        }
        if ($file == 'print') {
            
            $pdf = FacadePdf::loadView('projects.milestone.pdf', $page_data);
            return $pdf->stream('milestone.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'milestone.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $users = count($request->all()) > 0 ? $query->get() : Milestone::where('project_id', project_id_by_code($code))->get();
    
            $columns = ['#', 'name', 'description', 'task'];
            
            $callback = function() use ($columns, $users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                $count = 1;
            
                foreach ($users as $item) {  
                    $taskTitles = []; // Store task titles as an array
            
                    foreach ($item->tasks as $task) {
                        $taskModel = Task::where('id', $task)->first();
                        if ($taskModel) {
                            $taskTitles[] = $taskModel->title;
                        }
                    }
            
                    fputcsv($file, [
                        $count,
                        $item->title,
                        $item->description,
                        implode(', ', $taskTitles) // Convert array to a comma-separated string
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
