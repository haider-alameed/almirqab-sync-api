<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class LoginAlmirqabService
{
    public function token(string $baseUrl, string $email, string $password, string $cacheKey, int $minutes = 50): string
    {
        return Cache::remember($cacheKey, now()->addMinutes($minutes), function () use ($baseUrl, $email, $password) {
            return $this->login($baseUrl, $email, $password);
        });
    }

    public function login(string $baseUrl, string $email, string $password): string
    {
        Log::info('Sync started');
        $res = Http::baseUrl($baseUrl)
            ->acceptJson()
            ->post('/api/admin/auth/login', [
                'email' =>    $email,
                'password' =>  $password,
            ]);
        Log::info($res);
        if (! $res->successful()) {
            throw new RuntimeException("Login failed: ".$res->body());
        }

        $token = data_get($res->json(), 'data.token');

        if (! $token) {
            throw new RuntimeException("Token not found in response: ".$res->body());
        }

        return $token;
    }

    public function forget(string $cacheKey): void
    {
        Cache::forget($cacheKey);
    }
}
