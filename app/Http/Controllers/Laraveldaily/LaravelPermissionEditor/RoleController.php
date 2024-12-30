<?php

namespace App\Http\Controllers\Laraveldaily\LaravelPermissionEditor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController; //??
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller; //to place controller in subfolder


class RoleController extends Controller
{
    public function index()
    {   
        $roles = Role::withCount('permissions')->get();

        return view('laraveldaily.laravelPermissionEditor.roles.index', compact('roles'));
    }

    public function create() {
        $permissions = Permission::pluck('name', 'id');

        return view('laraveldaily.laravelPermissionEditor.roles.create', compact('permissions'));
    }

	public function show() {
        
    }
	
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles'],
            'permissions' => ['array'],
        ]);

        $role = Role::create(['name' => $request->input('name')]);

		if($role->givePermissionTo($request->input('permissions'))){
			return redirect()->route('roles.index')->with('flashSuccess', "Role {$role->name} was created successfully");
        } else {
			return redirect()->route('roles.index')->with('flashFailure', "Creating {$role->name} failed");
		}
        
    }

    public function edit(Role $role)
    {
        $permissions = Permission::pluck('name', 'id');

        return view('laraveldaily.laravelPermissionEditor.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'unique:roles,name,' . $role->id],
            'permissions' => ['array'],
        ]);

        $role->update(['name' => $request->input('name')]);

        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('roles.index')->with('flashSuccess', "Role {$role->name} was updated successfully");
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('flashSuccess', "Role {$role->name} was deleted successfully");
    }
}