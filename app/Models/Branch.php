<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Branch
 * 
 * @property int $branch_id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $phone
 * @property Carbon|null $open_time
 * @property Carbon|null $close_time
 * 
 * @property Collection|Appointment[] $appointments
 * @property Collection|Staffschedule[] $staffschedules
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Branch extends Model
{
	protected $table = 'branches';
	protected $primaryKey = 'branch_id';
	public $timestamps = false;

	protected $casts = [
		'open_time' => 'datetime',
		'close_time' => 'datetime'
	];

	protected $fillable = [
		'name',
		'address',
		'phone',
		'open_time',
		'close_time'
	];

	public function appointments()
	{
		return $this->hasMany(Appointment::class);
	}

	public function staffschedules()
	{
		return $this->hasMany(Staffschedule::class);
	}

	public function users()
	{
		return $this->hasMany(User::class);
	}
}
