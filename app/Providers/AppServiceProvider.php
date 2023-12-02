<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $menu = [
                'Comercial'=>(object)[
                    'child'=>[
                        (object)[
                        'url'=>route('comercial.performance'),
                        'text'=>'Performance Comercial'],
                        (object)[
                            'url'=>route('comercial.performance'),
                            'text'=>'Performance Delfi'],
                        (object)[
                            'url'=>route('comercial.performance'),
                            'text'=>'Performance Hola'],
                    ]
                ],
            ];
            $view->with('menu', collect($menu));
        });

    }
}
