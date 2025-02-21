<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Route;

class EnsureApiRequest
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('api/*') && !$request->route()) {
            return response()->json(['error' => 'Ruta no encontrada'], 404);
        }
        return $next($request);
    }
}
