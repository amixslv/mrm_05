<?php

namespace App\Services;

use App\Models\TrainingEvent;
use Illuminate\Support\Facades\DB;

class TrainingEventService
{
    
    public function getAllTrainingEventsWithUserName()
{
    return DB::table('trainingevents')
            ->leftJoin('users', 'trainingevents.user_id', '=', 'users.id')
            ->select('trainingevents.*', 'users.name as user_name')
            ->get();
}
    public function updateTrainingEvent(TrainingEvent $TrainingEvent, array $data)
    {
        $TrainingEvent->update($data);
    }

    
    public function getTrainingEventTableColumns()
    {
        $columns = DB::getSchemaBuilder()->getColumnListing('TrainingEvents');

        return $columns;
    }
}
