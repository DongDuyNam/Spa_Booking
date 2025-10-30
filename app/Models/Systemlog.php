<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Systemlog
 * 
 * @property int $log_id
 * @property int|null $user_id
 * @property string|null $action
 * @property string|null $description
 * @property Carbon|null $created_at
 * 
 * @property User|null $user
 *
 * @package App\Models
 */
class Systemlog extends Model
{
	protected $table = 'systemlogs';
	protected $primaryKey = 'log_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'action',
		'description'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
