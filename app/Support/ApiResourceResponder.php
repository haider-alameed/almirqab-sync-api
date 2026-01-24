<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiResourceResponder
{
    public static function collection(
        Request $request,
                $data,
        string $fullResource,
        string $compactResource
    ): AnonymousResourceCollection {
        $resource = self::pick($request, $fullResource, $compactResource);
        return $resource::collection($data);
    }

    public static function item(
        Request $request,
                $model,
        string $fullResource,
        string $compactResource
    ): JsonResource {
        $resource = self::pick($request, $fullResource, $compactResource);
        return new $resource($model);
    }

    private static function pick(Request $request, string $full, string $compact): string
    {
        $profile = $request->attributes->get('api_profile', 'full');

        $resource = ($profile === 'compact') ? $compact : $full;

        if (!class_exists($resource)) {
            throw new \RuntimeException("Resource class [$resource] not found. You must pass Resource::class, not '$profile'.");
        }

        return $resource;
    }
}
