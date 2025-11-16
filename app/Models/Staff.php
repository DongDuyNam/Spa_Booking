<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'staff_id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'specialization',
        'experience_years',
        'salary',
        'hire_date',
        'status',
    ];

    // Staff thuộc về User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Staff có nhiều lịch làm
    public function schedules()
    {
        return $this->hasMany(StaffSchedule::class, 'staff_id', 'staff_id');
    }
}
