<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


class UserController extends Controller
{
    public function index(Request $request, $type)
    {
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->user_server_side($request->customSearch);
        }

        $page_data['type_id'] = Role::where('title', $type)->value('id');
        $page_data['users'] = User::get();

        return view('users.index', $page_data);
    }

    public function create()
    {
        $page_data['roles'] = Role::all();

        $page_data['role_id'] = request()->query('id');
        return view('users.create', $page_data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'validationError' => $validator->getMessageBag()->toArray(),
            ]);
        }
        $file             = $request->file('photo');
        $data['role_id']  = $request->role_id;
        $data['name']     = $request->name;
        $data['email']    = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['photo']    = FileUploader::upload($file, 'user_photos');

        User::insert($data);
        return response()->json([
            'success' => 'User Created.',
        ]);
    }

    public function edit(Request $request, $id)
    {

        $data['user'] = User::where('id', $id)->first();
        return view('users.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $file_record = User::find($id);

        if (!$file_record) {
            return response()->json([
                'error' => 'User record not found.',
            ], 404);
        }

        $file          = $request->file('photo');
        $data['name']  = $request->name;
        $data['email'] = $request->email;
        if ($file) {
            $oldFilePath = public_path($file_record->photo);
            if ($file_record->photo && file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
            $data['photo'] = FileUploader::upload($file, 'user_photos');
        }

        $file_record->update($data);
        return response()->json([
            'success' => 'User Updated.',
        ]);
    }

    public function delete($id)
    {
        $file_record = User::find($id);

        if (!$file_record) {
            return response()->json([
                'error' => 'User record not found.',
            ], 404);
        }
        if ($file_record->photo) {
            $filePath = public_path($file_record->photo);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        $file_record->delete();

        User::where('id', $id)->delete();
        return response()->json([
            'success' => 'User Deleted.',
        ]);
    }

    public function multiDelete(Request $request)
    {
        $ids = $request->input('ids');

        if (!empty($ids)) {
            User::whereIn('id', $ids)->delete();
            return response()->json(['success' => 'Users Deleted.']);
        }

        return response()->json(['error' => 'No users selected for deletion.'], 400);
    }

    public function manage_profile()
    {
        return view('profile.index');
    }
    public function manage_profile_update(Request $request)
    {
        if ($request->type == 'general') {
            $profile['name']      = $request->name;
            $profile['email']     = $request->email;
            $profile['facebook']  = $request->facebook;
            $profile['linkedin']  = $request->linkedin;
            $profile['twitter']   = $request->twitter;
            $profile['about']     = $request->about;
            $profile['skills']    = $request->skills;
            $profile['biography'] = $request->biography;

            $user = User::find(Auth::user()->id);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');

                if ($user->photo) {
                    $oldFilePath = public_path($user->photo);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $profile['photo'] = FileUploader::upload($file, 'user_photos');
            }

            $user->update($profile);
        } else {
            $old_pass_check = Auth::attempt(['email' => Auth::user()->email, 'password' => $request->current_password]);

            if (!$old_pass_check) {
                return redirect()->back()->with('error', get_phrase('Current password wrong.'));
            }

            if ($request->new_password != $request->confirm_password) {
                return redirect()->back()->with('error', get_phrase('Confirm password not same.'));
            }

            $password = Hash::make($request->new_password);
            User::where('id', Auth::user()->id)->update(['password' => $password]);
        }
        return redirect()->back()->with('success', get_phrase('Profile Updated.'));

    }

    public function exportFile(Request $request, $file) {

        $query = User::query();

        $ids = $request->input('selectedIds'); // e.g. "[1,2,3]"
        if (!empty($ids) && $ids != '[]') {
            $idsArray = json_decode($ids, true); // convert to array
            if (is_array($idsArray)) {
                $query->whereIn('id', $idsArray);
            }
        }

        $query = $query->where('role_id', $request->role);

        if (isset($request->customSearch)) {
            $string = $request->customSearch;
            $query->where(function ($q) use ($string) {
                $q->where('name', 'like', "%{$string}%")
                    ->orWhere('email', 'like', "%{$string}%");
            });
        }

    
        if ($file == 'pdf') {
            $page_data['users'] = count($request->all()) > 0 ? $query->get() : User::get();
            $pdf = FacadePdf::loadView('users.pdf', $page_data);
    
            return $pdf->download('users.pdf');
        }
        if ($file == 'print') {
            $page_data['users'] = count($request->all()) > 0 ? $query->get() : User::get();
            $pdf = FacadePdf::loadView('users.pdf', $page_data);
    
            return $pdf->stream('users.pdf');
        }
    
        if ($file == 'csv') {
            $fileName = 'user.csv';

            $headers = [
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            ];
    
            // Use the filtered query to get the projects for CSV
            $users = count($request->all()) > 0 ? $query->get() : User::all();
    
            $columns = ['#', 'name', 'email', 'about', 'facebook', 'linkedin', 'twitter'];
            
            $callback = function() use ($columns, $users) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
    
                $count = 1;
                foreach ($users as $item) {    
                    fputcsv($file, [
                        $count,
                        $item->name,
                        $item->email,
                        $item->about,
                        $item->facebook,
                        $item->linkedin,
                        $item->twitter
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
