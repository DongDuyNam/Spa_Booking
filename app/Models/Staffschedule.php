<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSchedule extends Model
{
    use HasFactory;

    protected $table = 'staffschedules';
    protected $primaryKey = 'schedule_id';
    public $timestamps = true;

    protected $fillable = [
        'staff_id',
        'branch_id',
        'work_date',
        'shift',
        'start_time',
        'end_time',
        'notes',
        'status',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'staff_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}

