<?php

namespace App\Services;

use App\DataTransferObjects\SchoolDto;
use App\Filters\SchoolFilter;
use App\Models\School;
use App\Models\SchoolType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SchoolService
{
    public function __construct(private LoginAlmirqabService $loginService)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $perPage = $request->get('perPage', 25);
        $filter = resolve(SchoolFilter::class);
        $query = School::orderBy('order')->useFilter($filter);
        return $query->paginate($perPage);
    }

    public function list(): Collection
    {
        $filter = resolve(SchoolFilter::class);

        return School::
        with([])
            ->orderBy('order')
            ->useFilter($filter)
            ->get();
    }


    public function store(SchoolDto $schoolDto): School
    {

        return DB::transaction(function () use ($schoolDto) {
            $school = School::create([
                'mongo_id' => $schoolDto->mongoId,
                'name' => $schoolDto->name,
                'image' => $schoolDto->image,
                'closest_point' => $schoolDto->closestPoint,
                'manager_name' => $schoolDto->managerName,
                'manager_phone' => $schoolDto->managerPhone,
                'directorate' => $schoolDto->directorate,
                'governorate' => $schoolDto->governorate,
                'group_name' => $schoolDto->groupName,
                'gander' => $schoolDto->gander,
                'active' => $schoolDto->active,
            ]);

            return $school;
        });
    }

    public function update(School $school, SchoolDto $schoolDto): School
    {

        return DB::transaction(function () use ($school, $schoolDto) {
            $school->update([
                'mongo_id' => $schoolDto->mongoId,
                'name' => $schoolDto->name,
                'image' => $schoolDto->image,
                'closest_point' => $schoolDto->closestPoint,
                'manager_name' => $schoolDto->managerName,
                'manager_phone' => $schoolDto->managerPhone,
                'directorate' => $schoolDto->directorate,
                'governorate' => $schoolDto->governorate,
                'group_name' => $schoolDto->groupName,
                'gander' => $schoolDto->gander,
                'active' => $schoolDto->active,
            ]);

            return $school;
        });
    }


    public function getSchoolInfo($school): array
    {
        // $school has: id, base_url, email, password
        $cacheKey = "almirqab_token:school:{$school->id}";

        $token = $this->loginService->token(
            $school->base_url,
            $school->almirqab_email,
            $school->almirqab_password,
            $cacheKey
        );

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/school');
        Log::info($res);
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
                ->get('/api/admin/school');
        }

        $res->throw();
        $data = $res->json();
        return $data["data"];
    }


    public function updateSchoolFromMurqaib()
    {
        $id = 1;

        $school = School::findOrFail($id);

        $info = $this->getSchoolInfo($school);

        $logoUrl = data_get($info, 'logo.original_url');
        $types = data_get($info, 'types', []);

        $school->update([
            'name' => data_get($info, 'name', $school->name),
            'closest_point' => data_get($info, 'closest_point', $school->closest_point),
            'manager_name' => data_get($info, 'manager_name', $school->manager_name),
            'manager_phone' => data_get($info, 'manager_phone', $school->manager_phone),
            'directorate' => data_get($info, 'directorate', $school->directorate),
            'governorate' => data_get($info, 'governorate', $school->governorate),
            'image' => $logoUrl ?: $school->image,
        ]);

        $schoolTypeIds = [];

        foreach ($types as $type) {

            $schoolType = SchoolType::updateOrCreate(
                ['id' => data_get($type, 'id')],
                ['school_type' => data_get($type, 'school_type')]
            );

            $schoolTypeIds[] = $schoolType->id;
        }

        $school->types()->sync($schoolTypeIds);


        return $school->fresh()->load('types');
    }


}
