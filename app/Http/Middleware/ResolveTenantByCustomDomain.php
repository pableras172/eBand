<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Stancl\Tenancy\Database\Models\Domain;
use Symfony\Component\HttpFoundation\Response;

class ResolveTenantByCustomDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // Skip central domains
        $centralDomains = config('tenancy.central_domains', []);
        if (in_array($host, $centralDomains)) {
            return $next($request);
        }

        // Try to find tenant by custom domain
        $domain = Domain::where('domain', $host)->first();

        if ($domain) {
            try {
                $domain->tenant->makeCurrent();
            } catch (\Exception $e) {
                return response('Tenant not found', 404);
            }
        }

        return $next($request);
    }
}
