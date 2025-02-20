<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function getRolesWithUserCount()
    {
        return Role::withCount('users')->get();
    }

    public function getRoleTableColumns()
    {
        $columns = DB::getSchemaBuilder()->getColumnListing('roles');
        
        return $columns;
    }
    
}

