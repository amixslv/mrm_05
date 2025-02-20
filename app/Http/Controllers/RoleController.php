<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Models\Role;


class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        $roles = $this->roleService->getRolesWithUserCount();
        $columns = $this->roleService->getRoleTableColumns();
        $columns[] = 'user_count';
        $pageTitle = 'Roles';

        
        return view('Users.roles', compact('roles', 'columns', 'pageTitle'));
    }

    public function create()
    {
        $pageTitle = 'Create Role';
        return view('Users.create-role', compact('pageTitle'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => ['required', 'string', 'max:255'],
        ]);

        $existingRole = Role::where('role', $request->role)->first();
        if ($existingRole) {
            return redirect()->route('roles.create')->with('error', 'Role already exists.');
        }

        $role = Role::create([
            'role' => $request->role,
            'active' => $request->has('active'),
            'can_assign_roles' => $request->has('can_assign_roles'),
            'create' => $request->has('create'),
            'edit' => $request->has('edit'),
            'delete' => $request->has('delete'),
            'cleaner' => $request->has('cleaner'),
            
        ]);

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $pageTitle = 'Edit Roles';
        return view('Users.edit-role', compact('role','pageTitle'));
    }

    public function update(Request $request, Role $role)
    {
        $data['role'] = $request->input('role');
        $data['active'] = $request->has('active');
        $data['can_assign_roles'] = $request->has('can_assign_roles');
        $data['create'] = $request->has('create');
        $data['edit'] = $request->has('edit');
        $data['delete'] = $request->has('delete');
        $data['cleaner'] = $request->has('cleaner');
        $role->update($data);
        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    }
}
