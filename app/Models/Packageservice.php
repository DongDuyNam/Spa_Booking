<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Packageservice
 * 
 * @property int $package_id
 * @property int $service_id
 * 
 * @property Servicepackage $servicepackage
 * @property Service $service
 *
 * @package App\Models
 */
class Packageservice extends Model
{
	protected $table = 'packageservices';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'package_id' => 'int',
		'service_id' => 'int'
	];

	public function servicepackage()
	{
		return $this->belongsTo(Servicepackage::class, 'package_id');
	}

	public function service()
	{
		return $this->belongsTo(Service::class);
	}
}
