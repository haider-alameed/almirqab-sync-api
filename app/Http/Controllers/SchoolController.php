<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\SchoolDto;
use App\Enums\Permissions\SchoolPermission;

use App\Http\Requests\School\SchoolStoreRequest;
use App\Http\Requests\School\SchoolUpdateRequest;
use App\Http\Resources\SchoolCollection;
use App\Http\Resources\SchoolResource;
use App\Models\School;
use App\Services\SchoolService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SchoolController extends Controller
{
    public function __construct(private readonly SchoolService $schoolService)
    {
    }

    public function index(Request $request): SchoolCollection
    {
        Gate::authorize(SchoolPermission::Index);
        $schools = $this->schoolService->index($request);

        return new SchoolCollection($schools);
    }

    public function list(): SchoolCollection
    {
        Gate::authorize(SchoolPermission::List);
        $schools = $this->schoolService->list();

        return new SchoolCollection($schools);
    }


    public function store(SchoolStoreRequest $request): SchoolResource
    {
//        Gate::authorize(SchoolPermission::Create);
        $schoolDto = SchoolDto::fromRequest($request);
        $school = $this->schoolService->store($schoolDto);
        return new SchoolResource($school);
    }

    public function show(School $school)
    {
        Gate::authorize(SchoolPermission::View);


        return new SchoolResource($school);
    }

    public function update(School $school, SchoolUpdateRequest $request): SchoolResource
    {
        Gate::authorize(SchoolPermission::Update);


        $schoolDto = SchoolDto::fromRequest($request);
        $school = $this->schoolService->update($school, $schoolDto);
        return new SchoolResource($school);
    }
}
