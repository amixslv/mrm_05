<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'quantity',
        'status',
        'user_id',
        'assigned_department',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    

    public static function getAllTypes()
    {
        return self::pluck('type')->toArray();
    }

    
    public static function getAllStatuses()
    {
        return self::pluck('status')->toArray();
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_resource')->withPivot('quantity');
    }
    
}
