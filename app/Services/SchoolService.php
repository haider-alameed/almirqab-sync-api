<?php

namespace App\Services;

use App\DataTransferObjects\SchoolDto;
use App\Filters\SchoolFilter;
use App\Models\School;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;



class SchoolService
{
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



    public function store(SchoolDto $clinicDto): School
    {

        return DB::transaction(function () use ($clinicDto) {
            $clinic = School::create([
                'mongo_id' => $clinicDto->mongoId,
                'name' => $clinicDto->name,
                'image' => $clinicDto->image,
                'closest_point' => $clinicDto->closestPoint,
                'manager_name' => $clinicDto->managerName,
                'manager_phone' => $clinicDto->managerPhone,
                'directorate' => $clinicDto->directorate,
                'governorate' => $clinicDto->governorate,
                'group_name' => $clinicDto->groupName,
                'gander' => $clinicDto->gander,
                'active' => $clinicDto->active,
            ]);

            return $clinic;
        });
    }

    public function update(School $clinic, SchoolDto $clinicDto): School
    {

        return DB::transaction(function () use ($clinic, $clinicDto) {
            $clinic->update([
                'mongo_id' => $clinicDto->mongoId,
                'name' => $clinicDto->name,
                'image' => $clinicDto->image,
                'closest_point' => $clinicDto->closestPoint,
                'manager_name' => $clinicDto->managerName,
                'manager_phone' => $clinicDto->managerPhone,
                'directorate' => $clinicDto->directorate,
                'governorate' => $clinicDto->governorate,
                'group_name' => $clinicDto->groupName,
                'gander' => $clinicDto->gander,
                'active' => $clinicDto->active,
            ]);

            return $clinic;
        });
    }
}
