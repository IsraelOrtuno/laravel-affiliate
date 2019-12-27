<?php


namespace Devio\Affiliate\Middleware;


class RequiresPartnership
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $user = $this->auth->user();
        if ($user && method_exists($user, 'isPartner') && $user->isPartner()) {
            return $next($request);
        }

        if ($request->ajax()) {
            return response('Forbidden.', 403);
        }

        throw new AccessDeniedHttpException;
    }
}