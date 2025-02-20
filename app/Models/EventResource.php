<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventResource extends Model
{
    protected $table = 'event_resource';
    
    use HasFactory;
    

    protected $fillable = [
        'event_id',
        'resource_name',
        'quantity',
    ];
}
