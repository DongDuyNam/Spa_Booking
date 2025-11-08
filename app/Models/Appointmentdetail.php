<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentDetail extends Model
{
    protected $table = 'appointmentdetails';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'appointment_id' => 'int',
        'service_id' => 'int',
        'quantity' => 'int',
        'unit_price' => 'float'
    ];

    protected $fillable = [
        'appointment_id',
        'service_id',
        'quantity',
        'unit_price'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
