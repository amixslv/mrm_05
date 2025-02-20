<?php

namespace App\Services;

use App\Models\Resource;
use Illuminate\Support\Facades\DB;

class ResourceService
{
    public function getAllResourcesWithUserName()
    {
        return Resource::with('user')
            ->select('resources.*', 'users.name as user_name')
            ->leftJoin('users', 'resources.user_id', '=', 'users.id')
            ->get();
    }

    public function updateResource(Resource $resource, array $data)
    {
        $resource->update($data);
    }

    public function getResourceTableColumns()
    {
        $columns = DB::getSchemaBuilder()->getColumnListing('resources');

        return $columns;
    }

    
    public function getResourceTotalSummary()
    {
        return DB::table('resources')
            ->select('name', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('name')
            ->get();
    }

    public function getResourceSummary($excludeStatus = null)
    {
        $query = DB::table('resources')
            ->select('name', 'type', 'status', 'assigned_department', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('name', 'type', 'status', 'assigned_department')
            ->orderBy('name', 'asc');

        if ($excludeStatus) {
            $query->where('status', '=', $excludeStatus);
        }

        return $query->get();
    }

}
