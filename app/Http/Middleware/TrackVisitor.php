<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;

class TrackVisitor
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->is('admin/*') && !$request->is('login') && !$request->ajax()) {
            VisitorLog::create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'page' => $request->path(),
                'visited_at' => now(),
            ]);
        }

        return $next($request);
    }
}
