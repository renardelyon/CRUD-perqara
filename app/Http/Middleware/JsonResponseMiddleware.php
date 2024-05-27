<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class JsonResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $originalData = $response->getData(true);
            $formattedResponse = [
                'status_code' => $response->getStatusCode(),
                'status_message' => $response->getStatusCode() === 200 ? 'success' : 'error',
                'data' => $originalData
            ];

            return response()->json($formattedResponse, $response->getStatusCode(), $response->headers->all());
        }

        return $response;
    }
}
