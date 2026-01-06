<?php

namespace App\Services;

use App\Models\School;
use Illuminate\Support\Facades\Http;

class TeacherService
{
    public function __construct(private LoginAlmirqabService $loginService) {}

    public function getTeachers(
        object $school,
        int $page = 1,
        int $itemsPerPage = 20,
        string $sortKey = 'person.full_name',
        string $sortOrder = 'asc',
        bool $datatable = true,
        bool $cancelable = true,
    ): array {
        $cacheKey = "almirqab_token:school:{$school->id}";

        $token = $this->loginService->token(
            $school->base_url,
            $school->email,
            $school->password,
            $cacheKey
        );

        $query = [
            'datatable' => $datatable ? 'true' : 'false',
            'cancelable' => $cancelable ? 'true' : 'false',
            'page' => $page,
            'itemsPerPage' => $itemsPerPage,
            'sortBy' => [
                ['key' => $sortKey, 'order' => $sortOrder],
            ],
        ];

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/teacher', $query);

        // if token expired -> relogin once
        if ($res->status() === 401) {
            $this->loginService->forget($cacheKey);

            $token = $this->loginService->token(
                $school->base_url,
                $school->email,
                $school->password,
                $cacheKey
            );

            $res = Http::baseUrl($school->base_url)
                ->acceptJson()
                ->withToken($token)
                ->get('/api/admin/teacher', $query);
        }

        $res->throw();

        return $res->json();
    }
    public function updateTeacherFromMurqaib()
    {
        $school=School::find(1);
     return   $this->getTeachers(
            $school,
            1,
            1000,


        );
    }
}
