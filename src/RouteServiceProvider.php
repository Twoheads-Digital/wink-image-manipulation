<?php

namespace WinkImageManipulation;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        Route::get('wink-image/{id}/{umid}/{method}', function($id, $umid, $method) {

            $name = Cache::get($umid);

            return (new $name)->findOrFail($id)->imageResponse($method);

        })
            ->name('wink-image');
    }

}
