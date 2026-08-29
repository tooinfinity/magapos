<?php

use App\Http\Middleware\ShareGeneralSettings;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter;
use Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath;
use Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Laratrust\Middleware\LaratrustRole::class,
            'permission' => \Laratrust\Middleware\LaratrustPermission::class,
            'ability' => \Laratrust\Middleware\LaratrustAbility::class,
            'localeSessionRedirect' => LocaleSessionRedirect::class,
            'localizationRedirect' => LaravelLocalizationRedirectFilter::class,
            'localeViewPath' => LaravelLocalizationViewPath::class,
        ]);

        $middleware->web(append: [
            ShareGeneralSettings::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
