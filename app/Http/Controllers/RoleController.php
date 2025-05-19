<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(Request $request)
    {

        $page_data['roles'] = Role::get();
        if ($request->ajax()) {
            return app(ServerSideDataController::class)->role_server_side($request->customSearch, $request->role, $request->permission);
        }

        return view('roles.index', $page_data);
    }

    public function permission()
    {
        return view('roles.permission');
    }

}
