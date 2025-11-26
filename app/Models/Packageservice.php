<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageService extends Model
{
    protected $table = 'package_services';
    public $incrementing = false;
    public $timestamps = false;

    protected $casts = [
        'package_id' => 'int',
        'service_id' => 'int',
    ];

    public function package()
    {
        return $this->belongsTo(ServicePackage::class, 'package_id', 'package_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'service_id');
    }
}
