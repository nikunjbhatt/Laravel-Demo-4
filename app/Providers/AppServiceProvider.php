<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Pagination\Paginator;

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
        Route::pattern('userId', '[0-9]+');
        //Route::whereNumber('userId'); // not working
		View::share('key', 'value');
		Paginator::useBootstrapFive();

		DB::listen(function (QueryExecuted $query) {
            //\Log::info($query->sql);
            //\Log::info($query->bindings);
            //\Log::info($query->time);
            \Log::info($query->toRawSql());
        });
    }
}
