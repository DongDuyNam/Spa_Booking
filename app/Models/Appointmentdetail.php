<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentDetail extends Model
{
    protected $table = 'appointmentdetails';   
    protected $primaryKey = null;              
    public $incrementing = false;              
    public $timestamps = false;

    protected $fillable = [
        'appointment_id',
        'service_id',
        'quantity',
        'unit_price'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id', 'appointment_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}
