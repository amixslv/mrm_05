<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\EnumService;

class UserController extends Controller
{
    protected $userService;
    protected $enumService;

    public function __construct(UserService $userService, EnumService $enumService)
    {
        $this->userService = $userService;
        $this->enumService = $enumService;
    }

    public function index()
    {
        $users = $this->userService->getUsersWithRoles();
        $columns = $this->userService->getUserTableColumns();
        $pageTitle = 'Users';


        $columns[] = 'department';
        $columns[] = 'role';
        return view('Users.users', compact('users', 'columns', 'pageTitle'));
    }

    public function edit($id)
{
    $user = User::with('role')->findOrFail($id);
    $roles = $this->enumService->getEnumIDValues('roles', 'role','active',1);
    $enumCountry = $this->enumService->getEnumValues('users', 'country');
    $enumStructure = $this->enumService->getEnumValues('users', 'structure');
    $enumSubStructure = $this->enumService->getEnumValues('users', 'sub_structure');
    $pageTitle = 'Users';
    return view('Users.edit-user', compact('user', 'roles', 'pageTitle', 'enumCountry', 'enumStructure', 'enumSubStructure'));
}


    public function update(Request $request, User $user)
    {
        $validDate = $request->validate([
            'email' => 'required|email|max:255',
            'role_id' => 'required|integer|exists:roles,id',
            'country' => 'required|string',
            'structure' => 'required|string',
            'sub_structure' => 'required|string',
        ]);
        $data['email'] = $validDate['email'];
        $data['role_id'] = $validDate['role_id'];
        $data['active'] = $request->has('active') ? 1 : 0;
        $data['country'] = $validDate['country'];
        $data['structure'] = $validDate['structure'];
        $data['sub_structure'] = $validDate['sub_structure'];
        $user->update($data);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
