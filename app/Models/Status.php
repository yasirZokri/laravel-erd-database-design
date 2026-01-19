<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $timestamps = false;
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
