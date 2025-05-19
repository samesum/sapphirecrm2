<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FileUploader;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class FileController extends Controller
{
    public function index(Request $request)
    {

        if($request->ajax()){
            return app(ServerSideDataController::class)->file_server_side($request->project_id, $request->customSearch, $request->date_range, $request->type, $request->uploaded_by, $request->size);             
        }
        $page_data['files'] = File::get();

        return view('projects.file.index', $page_data);

    }
    public function create()
    {

        $page_data['project_id'] = Project::where('code', request()->query('code'))->value('id');
        return view('projects.file.create', $page_data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }

        $file = $request->file('file');

        $data['project_id'] = $request->project_id;
        $data['user_id']    = Auth::user()->id;
        $data['title']      = $request->title;
        $data['extension']  = $file->getClientOriginalExtension();
        $data['size']       = round(($file->getSize() / (1024 * 1024)), 2);
        $data['file']       = FileUploader::upload($file, 'project_file');

        File::insert($data);
        return response()->json([
            'success' => 'File Uploaded.',
        ]);
    }

    public function delete($id)
    {
        $file_record = File::find($id);

        if (!$file_record) {
            return response()->json([
                'error' => 'File record not found.',
            ], 404);
        }
        $file_path = public_path($file_record->file);
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $file_record->delete();
        File::where('id', $id)->delete();

        return response()->json([
            'success' => 'File Deleted.',
        ]);
    }

    public function edit(Request $request, $id)
    {

        $data['file'] = File::where('id', $id)->first();
        return view('projects.file.edit', $data);
    }
    public function update(Request $request, $id)
    {
        $file        = $request->file('file');
        $file_record = File::find($id);

        if (!$file_record) {
            return response()->json([
                'error' => 'File record not found.',
            ], 404);
        }

        $data['title'] = $request->title;

        if ($file) {
            $oldFilePath = public_path($file_record->file);

            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }

            $data['extension'] = $file->getClientOriginalExtension();
            $data['size']      = round(($file->getSize() / 1048576), 2);
            $data['file']      = FileUploader::upload($file, 'project_file');
        }

        $file_record->update($data);

        return response()->json([
            'success' => 'File updated.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('ids'); // e.g. "[1,2,3]"

        if (!empty($ids)) {
            File::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Files Deleted.']);
        }

        return response()->json(['error' => 'No files selected for deletion.'], 400);
    }

    public function download($id)
    {
        $file      = File::where('id', $id)->first();
        $file_path = public_path($file->file);

        return Response::download($file_path);
    }

    public function exportFile(Request $request, $file, $code) {

        $query = File::query();

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
        if ($request->type && $request->type != 'all') {
            $query->where('extension', $request->type);
        }
        if ($request->uploaded_by && $request->uploaded_by != 'all') {
            $query->where('user_id', $request->uploaded_by);
        }
        if ($request->size && $request->size !== 'all') {
            list($minSize, $maxSize) = explode('|', $request->size);
            $minSize                 = (float) $minSize;
            $maxSize                 = (float) $maxSize;
            $query->whereBetween('size', [$minSize, $maxSize]);
        }

        $page_data['files'] = count($request->all()) > 0 ? $query->get() : File::where('project_id', project_id_by_code($code))->get();
        
        if ($file == 'pdf') {
            $pdf = FacadePdf::loadView('projects.file.pdf', $page_data);
            return $pdf->download('files.pdf');
        }
        if ($file == 'print') {
            $pdf = FacadePdf::loadView('projects.file.pdf', $page_data);
            return $pdf->stream('files.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'files.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $users = count($request->all()) > 0 ? $query->get() : File::where('project_id', project_id_by_code($code))->get();
    
            $columns = ['#', 'title', 'user', 'extension', 'size'];
            
            $callback = function() use ($columns, $users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                $count = 1;
            
                foreach ($users as $item) { 
                 
                    fputcsv($file, [
                        $count,
                        $item->title,
                        User::where('id', $item->user_id)->first()->name,
                        $item->extension,
                        $item->size
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
