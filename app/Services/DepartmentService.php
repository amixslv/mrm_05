<?php

namespace App\Services;

use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    
    public function getDepartmentTableColumns()
    {
        $columns = DB::getSchemaBuilder()->getColumnListing('department');
        
        return $columns;
    }

    public function getAllDepartmentsWithUserName()
    {
        return Department::with('user')
            ->select('department.*', 'users.name as user_name')
            ->leftJoin('users', 'department.user_id', '=', 'users.id')
            ->get();
    }

    public function createDepartment(array $data)
    {
        return Department::create($data);
    }
    
}

