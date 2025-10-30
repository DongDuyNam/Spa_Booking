<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 * 
 * @property int $payment_id
 * @property int|null $appointment_id
 * @property string|null $method
 * @property float|null $amount
 * @property string|null $status
 * @property int|null $created_by
 * @property Carbon|null $created_at
 * 
 * @property Appointment|null $appointment
 * @property User|null $user
 *
 * @package App\Models
 */
class Payment extends Model
{
	protected $table = 'payments';
	protected $primaryKey = 'payment_id';
	public $timestamps = false;

	protected $casts = [
		'appointment_id' => 'int',
		'amount' => 'float',
		'created_by' => 'int'
	];

	protected $fillable = [
		'appointment_id',
		'method',
		'amount',
		'status',
		'created_by'
	];

	public function appointment()
	{
		return $this->belongsTo(Appointment::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by');
	}
}
