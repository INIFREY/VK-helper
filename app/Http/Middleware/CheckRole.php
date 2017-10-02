<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array $roles Роли пользователя
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {

        // Если пользователь заблокирован
        if ($request->user()->hasRole('blocked')) {
            dd('block');
        }

        // Если нет этой роли
        if (array_search($request->user()->role, $roles)===false) {
            dd('not');
        }

        return $next($request);
    }
}
