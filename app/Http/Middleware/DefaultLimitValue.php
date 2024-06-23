<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DefaultLimitValue
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $limit = $request->input('limit');

        $limit = filter_var($limit, FILTER_VALIDATE_INT) !== false && (int) $limit >= 1
            ? $limit
            : config('gigmedia.api.default_per_page_limit');

        $request->merge(['limit' => (int) $limit]);

        return $next($request);
    }
}
