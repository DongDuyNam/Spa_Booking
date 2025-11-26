<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';
    protected $primaryKey = 'appointment_id';
    public $timestamps = true;

    protected $casts = [
        'customer_id' => 'int',
        'staff_id' => 'int',
        'branch_id' => 'int',
        'appointment_date' => 'date:Y-m-d',
        'appointment_time' => 'string',   
        'duration_minutes' => 'int',
        'total_amount' => 'float',
    ];

    protected $fillable = [
        'customer_id',
        'staff_id',
        'branch_id',
        'appointment_date',
        'appointment_time',   
        'duration_minutes',
        'note',
        'status',
    ];

    // 🔹 Khách hàng đặt lịch
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // 🔹 Nhân viên thực hiện
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    // 🔹 Chi nhánh (nếu có)
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    // 🔹 Các dịch vụ thuộc lịch hẹn này
    public function details()
    {
        return $this->hasMany(AppointmentDetail::class, 'appointment_id');
    }

    // 🔹 Thanh toán
    public function payments()
    {
        return $this->hasMany(Payment::class, 'appointment_id');
    }

    // 🔹 Đánh giá
    public function reviews()
    {
        return $this->hasMany(Review::class, 'appointment_id');
    }

    // 🔹 Tính tổng tiền tự động
    public function getTotalAmountAttribute()
    {
        return $this->details->sum(fn($d) => $d->unit_price * ($d->quantity ?? 1));
    }
}
