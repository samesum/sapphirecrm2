<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

        ]);

        if (User::count() == 0) {
            $admin        = Role::where('title', 'admin')->first();
            $role['id']   = $admin ? $admin->id : Role::insertGetId(['title' => 'admin']);
            $role['name'] = 'admin';
        } else {
            $client       = Role::where('title', 'client')->first();
            $role['id']   = $client ? $client->id : Role::insertGetId(['title' => 'client']);
            $role['name'] = 'client';
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role_id'  => $role['id'],
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route($role['name'] . '.dashboard', absolute: false));
    }

    public function RolePermissions(Role $role)
    {
        $role_permissions = [];

        if ($role->title === 'admin') {
            $role_permissions = Permission::all();
        } elseif ($role->title === 'client') {
            $role_permissions = Permission::whereIn('title', ['create'])->get(); // Client gets specific permissions

        }
        foreach ($role_permissions as $permission) {
            RolePermission::firstOrCreate([
                'role_id'       => $role->id,
                'permission_id' => $permission->id,
            ]);
        }
    }
}
