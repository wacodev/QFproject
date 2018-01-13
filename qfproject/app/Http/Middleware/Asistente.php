<?php

namespace qfproject\Http\Middleware;

use Closure;

/**
 * ---------------------------------------------------------------------------
 * Clases agregadas.
 * ---------------------------------------------------------------------------
 */

use Illuminate\Contracts\Auth\Guard;

class Asistente
{
    /**
     * ---------------------------------------------------------------------------
     * The Guard implementation.
     *
     * @var Guard
     * ---------------------------------------------------------------------------
     */

    protected $auth;

    /**
     * ---------------------------------------------------------------------------
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     * ---------------------------------------------------------------------------
     */

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * ---------------------------------------------------------------------------
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     * ---------------------------------------------------------------------------
     */

    public function handle($request, Closure $next)
    {
        if ($this->auth->user()->asistente()) {
            return $next($request);
        } else {
            abort(401);
        }
    }
}
