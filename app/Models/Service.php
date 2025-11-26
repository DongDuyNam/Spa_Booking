<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Service
 * 
 * @property int $service_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $duration_minutes
 * @property float|null $price
 * @property string|null $category
 * @property bool|null $is_active
 * 
 * @property Collection|Appointmentdetail[] $appointmentdetails
 * @property Collection|Packageservice[] $packageservices
 *
 * @package App\Models
 */
class Service extends Model
{
	protected $table = 'services';
	protected $primaryKey = 'service_id';
	public $timestamps = false;

	protected $casts = [
		'duration_minutes' => 'int',
		'price' => 'float',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'description',
		'duration_minutes',
		'price',
		'category',
		'thumbnail',
		'is_active'
	];

	public function appointmentdetails()
	{
		return $this->hasMany(Appointmentdetail::class);
	}

	public function packageservices()
	{
		return $this->hasMany(Packageservice::class);
	}
}
