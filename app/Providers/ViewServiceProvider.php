<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\ServicePackage;
use App\Models\Service;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('layouts.app', function ($view) {
            $view->with('services', Service::orderBy('name')->get());
        });

        View::composer('client.*', function ($view) {
            $view->with(
                'activePackages',
                ServicePackage::where('is_active', 1)->get()
            );
        });
    }
}
