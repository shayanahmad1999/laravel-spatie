<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //we define role here as well and in web as well and in blade as well define it where you want
    public static function middleware(): array
    {
        return [
            // new Middleware('role:Super Admin', only: ['index']),
            // new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('delete role'), only:['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index($role = null)
    {
        $data['roles'] = Role::all();
        $data['edit'] = Role::find($role);
        $data['permissions'] = Permission::all();
        // $roleId = intval($role);
        // $data['rolePermissions'] = DB::table('role_has_permissions')
        //     ->where('role_has_permissions.role_id',  $roleId)
        //     ->pluck('role_has_permissions.permission_id');
        return view('role-permission.role.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name'
        ]);
        $role = Role::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => [
                'nullable',
                'string',
                Rule::unique('roles')->ignore($role->id),
            ]
        ]);
        $role->update(['name' => $request->name]);
        return redirect()->route('role.index')->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully');
    }

    public function assignPermissionToRole(Request $request, Role $role)
    {
        $request->validate([
            'permissions' => 'required',
        ]);

        $role->syncPermissions($request->permissions);
        return redirect()->route('role.index')->with('success', 'Assign Permission to ' . $role->name . ' successfully');
    }

    public function assignRoleToUser(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required',
        ]);

        $user->syncRoles($request->roles);
        return redirect()->route('dashboard')->with('success', 'Assign Role to ' . $user->name . ' successfully');
    }
}
