<?php

namespace App\Middleware;

use Closure;
use Core\Http\Request;
use Core\Http\Respond;
use Core\Middleware\MiddlewareInterface;

final class CorsMiddleware implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        $header = respond()->getHeader();

        // Set the CORS headers
        $header->set('Access-Control-Allow-Origin', '*');
        $header->set('Access-Control-Expose-Headers', 'Authorization, Content-Type, Cache-Control, Content-Disposition');
        $header->set('Access-Control-Allow-Credentials', 'true');
        $header->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $header->set('Access-Control-Allow-Headers', 'Origin, Content-Type, Accept, Authorization, Accept-Language');

        // Handle the preflight request
        if ($request->method() === Request::OPTIONS) {
            return respond()->setCode(Respond::HTTP_NO_CONTENT);
        }

        // Proceed with the request
        return $next($request);
    }
}
