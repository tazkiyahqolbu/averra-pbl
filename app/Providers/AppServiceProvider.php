<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        config(['app.locale' => 'id']);
        Carbon::setLocale('id');

        // $user tersedia otomatis di semua view user.* tanpa perlu pass dari setiap controller
        View::composer('user.*', function ($view) {
            if (auth()->check()) {
                $view->with('user', auth()->user());
            }
        });
    }
}
