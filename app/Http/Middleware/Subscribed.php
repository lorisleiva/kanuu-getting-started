<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Subscribed
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->user() || ! $request->user()->isSubscribed()) {
            // Or redirect to a pricing page...
            abort(402, 'You must be subscribed to perform this action');
        }

        return $next($request);
    }
}
