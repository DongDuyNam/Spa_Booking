<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    protected $table = 'service_packages';
    protected $primaryKey = 'package_id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
        'price',
        'valid_from',
        'valid_to',
        'limit_usage',
        'duration_minutes',
        'duration_days',
        'thumbnail',
        'is_active',
    ];

    public function services()
    {
        return $this->belongsToMany(
            Service::class,
            'package_services',
            'package_id',
            'service_id'
        )->withPivot('quantity');
    }

    public function packageServices()
    {
        return $this->hasMany(PackageService::class, 'package_id', 'package_id');
    }
}
