<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Carbon::setLocale('ru');

        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        Blade::if('adminOrOwner', function () {
            return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isOwner());
        });

        Blade::if('employee', function () {
            return auth()->check() && auth()->user()->isEmployee();
        });
    }
}
