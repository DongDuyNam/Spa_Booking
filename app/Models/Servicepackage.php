<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Servicepackage
 * 
 * @property int $package_id
 * @property string|null $name
 * @property string|null $description
 * @property float|null $price
 * @property Carbon|null $valid_from
 * @property Carbon|null $valid_to
 * @property bool|null $is_active
 * 
 * @property Collection|Packageservice[] $packageservices
 *
 * @package App\Models
 */
class Servicepackage extends Model
{
	protected $table = 'servicepackages';
	protected $primaryKey = 'package_id';
	public $timestamps = false;

	protected $casts = [
		'price' => 'float',
		'valid_from' => 'datetime',
		'valid_to' => 'datetime',
		'is_active' => 'bool'
	];

	protected $fillable = [
		'name',
		'description',
		'price',
		'valid_from',
		'valid_to',
		'is_active'
	];

	public function packageservices()
	{
		return $this->hasMany(Packageservice::class, 'package_id');
	}
}
