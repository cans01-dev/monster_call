<?php

namespace App\Providers;

use App\Libs\MyCalendar;
use App\Libs\MyUtil;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('MyUtil', MyUtil::class);
        $this->app->bind('MyCalendar', MyCalendar::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        LogViewer::auth(function (Request $request) {
            return $request->user()
                && $request->user()->isAdmin();
        });
    }
}
