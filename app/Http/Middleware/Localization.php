<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return RedirectResponse|Response|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        /**
         * requests hasHeader is used to check the Accept-Language header from the REST API's
         */
        if ($request->hasHeader("Accept-Language")) {
            /**
             * If Accept-Language header found then set it to the default locale
             */
            App::setLocale($request->header("Accept-Language"));
        }
        return $next($request);
    }
}
