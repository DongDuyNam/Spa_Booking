<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Review
 * 
 * @property int $review_id
 * @property int|null $appointment_id
 * @property int|null $user_id
 * @property int|null $rating
 * @property string|null $comment
 * @property Carbon|null $created_at
 * 
 * @property Appointment|null $appointment
 * @property User|null $user
 *
 * @package App\Models
 */
class Review extends Model
{
	protected $table = 'reviews';
	protected $primaryKey = 'review_id';
	public $timestamps = false;

	protected $casts = [
		'appointment_id' => 'int',
		'user_id' => 'int',
		'rating' => 'int'
	];

	protected $fillable = [
		'appointment_id',
		'user_id',
		'rating',
		'comment'
	];

	public function appointment()
	{
		return $this->belongsTo(Appointment::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
