<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->force_password_change) {
            if ($request->route()?->getName() !== 'force.password.change'
                && $request->route()?->getName() !== 'force.password.change.store'
                && $request->route()?->getName() !== 'logout'
                && !$request->is('css/*')
                && !$request->is('js/*')
                && !$request->is('images/*')
                && !$request->is('favicon.ico')
                && !$request->is('storage/*')) {
                return redirect()->route('force.password.change')
                    ->with('warning', 'You must change your default password before continuing.');
            }
        }

        return $next($request);
    }
}
