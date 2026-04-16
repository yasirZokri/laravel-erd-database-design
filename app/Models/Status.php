<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'status_id', 'id');
    }
}
