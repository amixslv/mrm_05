<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function getUsersWithRoles()
{
    return User::with(['role' => function($query) {
        $query->select('id', 'role', 'can_assign_roles', 'create', 'edit', 'delete', 'cleaner');
    }])
    ->select(
        'id', 
        'name', 
        'email', 
        'active', 
        DB::raw('TRIM(
            CONCAT_WS(" ", 
                NULLIF(country, "-"), 
                NULLIF(structure, "-"), 
                NULLIF(sub_structure, "-")
            )
        ) AS department'),
        'role_id'
    )
    ->get();           
}


    public function getActiveRoles()
    {
        return Role::where('active', 1)->get();
    }
   

    public function updateUser(User $user, array $data)
    {
        $user->update($data);
    }

    
    public function getRoleTableColumns()
    {
        return DB::getSchemaBuilder()->getColumnListing('roles');
    }

    public function getUserTableColumns()
    {
        return DB::getSchemaBuilder()->getColumnListing('users');
    }
}
