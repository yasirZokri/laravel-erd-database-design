<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';
    protected $guard = 'admin';

    protected $primaryKey = 'admin_id'; // ✅ هنا أهم تعديل

    protected $fillable = [
        'admin_email',
        'admin_password',
        'isActive'
    ];

    protected $hidden = [
        'admin_password'
    ];

    public function getAuthPassword()
    {
        return $this->admin_password;
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'admin_id', 'admin_id');
    }
}
