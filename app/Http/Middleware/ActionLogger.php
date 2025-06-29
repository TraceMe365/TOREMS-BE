<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActionLog;

class ActionLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Get controller and method from the route action
        $route = $request->route();
        $action = $route ? $route->getActionName() : null;
        $controller = null;
        $method = null;
        if ($action && strpos($action, '@') !== false) {
            [$controller, $method] = explode('@', class_basename($action));
        }

        ActionLog::create([
            'action' => $request->method(),
            'controller' => $controller,
            'method' => $method,
            'user_id' => auth()->id(),
            'details' => json_encode($request->all()),
        ]);

        return $response;
    }
}
