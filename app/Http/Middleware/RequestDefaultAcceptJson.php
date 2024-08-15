<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Http\Request;

class RequestDefaultAcceptJson
{
    public function handle(Request $request, \Closure $next)
    {
        $accept = $request->headers->get('Accept');

        if ($accept === null || $accept === '*/*' || $accept === 'application/*') {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
