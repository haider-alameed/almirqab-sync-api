<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DetectApiClient
{
    public function handle(Request $request, Closure $next)
    {

        $defaultClient = config('api_clients.default', 'appa');
        $headerName    = config('api_clients.header', 'X-Client');
        $acceptMap     = config('api_clients.accept', []);
        $clients       = config('api_clients.clients', []);

        // 1) Try header first
        $client = strtolower((string) $request->header($headerName, ''));

        // 2) If no header, try Accept vendor type
        if ($client === '') {
            $accept = strtolower((string) $request->header('Accept', ''));
            foreach ($acceptMap as $media => $mappedClient) {
                if (str_contains($accept, strtolower($media))) {
                    $client = $mappedClient;
                    break;
                }
            }
        }

        // 3) Validate + fallback to default
        if ($client === '' || !array_key_exists($client, $clients)) {
            $client = $defaultClient;
        }


        // Store both client + profile (compact/full)
        $request->attributes->set('api_client', $client);
        $request->attributes->set('api_profile', $clients[$client]['profile'] ?? 'full');



        return $next($request);
    }
}
