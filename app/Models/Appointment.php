<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Appointment
 * 
 * @property int $appointment_id
 * @property int|null $customer_id
 * @property int|null $staff_id
 * @property int|null $branch_id
 * @property Carbon|null $scheduled_time
 * @property int|null $duration_minutes
 * @property float|null $total_amount
 * @property string|null $status
 * 
 * @property User|null $user
 * @property Branch|null $branch
 * @property Collection|Appointmentdetail[] $appointmentdetails
 * @property Collection|Payment[] $payments
 * @property Collection|Review[] $reviews
 *
 * @package App\Models
 */
class Appointment extends Model
{
	protected $table = 'appointments';
	protected $primaryKey = 'appointment_id';
	public $timestamps = false;

	protected $casts = [
		'customer_id' => 'int',
		'staff_id' => 'int',
		'branch_id' => 'int',
		'scheduled_time' => 'datetime',
		'duration_minutes' => 'int',
		'total_amount' => 'float'
	];

	protected $fillable = [
		'customer_id',
		'staff_id',
		'branch_id',
		'scheduled_time',
		'duration_minutes',
		'total_amount',
		'status'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'staff_id');
	}

	public function branch()
	{
		return $this->belongsTo(Branch::class);
	}

	public function appointmentdetails()
	{
		return $this->hasMany(Appointmentdetail::class);
	}

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}

	public function reviews()
	{
		return $this->hasMany(Review::class);
	}
}
