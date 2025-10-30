<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointmentdetail
 * 
 * @property int $appointment_id
 * @property int $service_id
 * @property int|null $quantity
 * @property float|null $unit_price
 * 
 * @property Appointment $appointment
 * @property Service $service
 *
 * @package App\Models
 */
class Appointmentdetail extends Model
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
		'quantity',
		'unit_price'
	];

	public function appointment()
	{
		return $this->belongsTo(Appointment::class);
	}

	public function service()
	{
		return $this->belongsTo(Service::class);
	}
}
