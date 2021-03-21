<?php

namespace App\Http\Middleware;

use App\Models\Configuration;
use Closure;
use Illuminate\Http\Request;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $configuration = Configuration::where('name', '=', 'maintenance-mode')
            ->first();

        if ($configuration->value) {
            return redirect()->route('maintenance.index');
        } else {
            return $next($request);
        }
    }
}
