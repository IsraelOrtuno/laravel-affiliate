<?php

namespace Devio\Affiliate\Middleware;

use Closure;

class TrackAffiliate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $manager = app(Manager::class);

        if ($manager->shouldInstall()) {
            return $manager->redirect();
        }

        \Debugbar::info($request->hasCookie('referrer'));

        return $next($request);
    }
}
