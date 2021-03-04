<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Traits\HelperTrait;

class TryAuth
{
    use HelperTrait;

    public function __construct()
    {
        auth()->setDefaultDriver('api');
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            auth()->userOrFail();
        } catch (\Exception $e) {
            return $this->errorResponse(400, [], 'Hatalı Token');
        }
        return $next($request);
    }
}
