<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    

    use HasFactory;

    protected $fillable = [
        'name',
        'responsible_department',
        'start_date_time',
        'end_date_time',
        'status',
        'user_id'
    ];

    public function resources()
{
    return $this->belongsToMany(Resource::class, 'event_resource')->withPivot('quantity');
}

    
}

