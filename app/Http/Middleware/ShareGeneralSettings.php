<?php

namespace App\Http\Middleware;

use App\Models\GeneralSetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class ShareGeneralSettings
{
    public function handle(Request $request, Closure $next): Response
    {
        $setting = GeneralSetting::find(1);

        if ($setting) {
            View::share('store_id', $setting->id);
            View::share('store_name', $setting->store_name);
            View::share('activity', $setting->activity);
            View::share('phone', $setting->phone);
            View::share('address', $setting->address);
            View::share('start_day', $setting->start_day);
            View::share('logo', $setting->image);
            View::share('investment_capital', $setting->investment_capital);
            View::share('rc', $setting->rc);
            View::share('article', $setting->article);
            View::share('nif', $setting->nif);
            View::share('nis', $setting->rc);
        }

        return $next($request);
    }
}
