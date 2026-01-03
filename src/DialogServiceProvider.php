<?php

namespace Native\Mobile\Providers;

use Illuminate\Support\ServiceProvider;
use Native\Mobile\Dialog;

class DialogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Dialog::class, function () {
            return new Dialog;
        });
    }
}