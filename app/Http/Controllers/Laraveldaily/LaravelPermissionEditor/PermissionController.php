<?php

namespace App\Http\Controllers\Laraveldaily\LaravelPermissionEditor;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController; //??
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\Controller; //to place controller in subfolder

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::with('roles:name')->get();

        return view('laraveldaily.laravelPermissionEditor.permissions.index', compact('permissions'));
    }

    public function create() {
        $roles = Role::pluck('name', 'id');

        return view('laraveldaily.laravelPermissionEditor.permissions.create', compact('roles'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:permissions'],
            'roles' => ['array'],
        ]);

        $permission = Permission::create($data);

        if ($permission->syncRoles($request->input('roles'))){

            return redirect()->route('permissions.index')->with('flashSuccess', "Permission {$permission->name} was created successfully");
		} else {
		    return redirect()->route('permissions.index')->with('flashFailure', "Creating {$permission->name} failed");
		}
    
    }

    public function edit(Permission $permission) {
        $roles = Role::pluck('name', 'id');

        return view('laraveldaily.laravelPermissionEditor.permissions.edit', compact('permission', 'roles'));
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:permissions,id,' . $permission->id],
            'roles' => ['array'],
        ]);

        $permission->update($data);

        $permission->syncRoles($request->input('roles'));

        return redirect()->route('permissions.index')->with('flashSuccess', "Permission {$permission->name} was updated successfully");
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')->with('flashSuccess', "Permission {$permission->name} was deleted successfully");
    }
    
}
