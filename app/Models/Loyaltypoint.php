<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Loyaltypoint
 * 
 * @property int $point_id
 * @property int|null $customer_id
 * @property int|null $points
 * @property Carbon|null $last_updated
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class Loyaltypoint extends Model
{
	protected $table = 'loyaltypoints';
	protected $primaryKey = 'point_id';
	public $timestamps = false;

	protected $casts = [
		'customer_id' => 'int',
		'points' => 'int',
		'last_updated' => 'datetime'
	];

	protected $fillable = [
		'customer_id',
		'points',
		'last_updated'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'customer_id');
	}
}
