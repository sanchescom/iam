<?php
/**
 * Created by PhpStorm.
 * User: thiagovictorino
 * Date: 1/4/18
 * Time: 14:06
 */

namespace thiagovictorino\IAM\Http\Middleware;


class IAMCors {
    public function handle($request, \Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    }
}