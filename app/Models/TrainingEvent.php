<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingEvent extends Model
{
    use HasFactory;

    
    
    protected $fillable = [
        'name',
        'responsible_department',
        'start_date_time',
        'end_date_time',
        'required_resources',
        'status',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function getAllStatuses()
    {
        return self::pluck('status')->toArray();
    }
    
}
