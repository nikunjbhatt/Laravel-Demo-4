<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
//use Illuminate\Foundation\Http\Middleware\TrimStrings;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
		then: function () {
			Route::middleware('api')
				->prefix('webhooks')
				->name('webhooks.')
				->group(base_path('routes/webhooks.php'));
		},
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->remove([
        	ConvertEmptyStringsToNull::class,
        	//TrimStrings::class,
    	]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
