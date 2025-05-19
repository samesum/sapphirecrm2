<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RolePermissionController extends Controller
{
    public function store(Request $request)
    {
        $role_id       = $request->input('role_id');
        $permission_id = $request->input('permission');

        $role_permissions = RolePermission::where('role_id', $role_id)->pluck('permission_id')->toArray();

        if (($index = array_search($permission_id, $role_permissions)) !== false) {
            RolePermission::where('role_id', $role_id)
                ->where('permission_id', $permission_id)
                ->delete();
        } else {
            RolePermission::create([
                'role_id'       => $role_id,
                'permission_id' => $permission_id,
            ]);
        }

        return response()->json([
            'success' => 'Permission has been updated.',
        ]);
    }

}
