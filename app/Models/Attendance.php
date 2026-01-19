<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'attendance_id';

    protected $fillable = [
        'user_id',
        'status_id',
        'details'
    ];
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
