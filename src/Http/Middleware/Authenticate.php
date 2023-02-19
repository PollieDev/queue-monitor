<?php

namespace QueueMonitor\Http\Middleware;

use Illuminate\Support\Facades\Gate;

class Authenticate
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|null
     */
    public function handle($request, $next)
    {
        if (Gate::check('viewQueueMonitor', [$request->user()]) || app()->environment('local'))
            return $next($request);

        abort(403);
    }
}
