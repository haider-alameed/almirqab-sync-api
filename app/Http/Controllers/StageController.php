<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\StageDto;
use App\Enums\Permissions\StagePermission;

use App\Http\Requests\Stage\StageStoreRequest;
use App\Http\Requests\Stage\StageUpdateRequest;
use App\Http\Resources\StageCollection;
use App\Http\Resources\StageResource;
use App\Models\School;
use App\Models\Stage;
use App\Services\StageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class StageController extends Controller
{
    public function __construct(private readonly StageService $schoolService)
    {
    }

    public function index(Request $request): StageCollection
    {
        Gate::authorize(StagePermission::Index);
        $schools = $this->schoolService->index($request);

        return new StageCollection($schools);
    }

    public function list(): StageCollection
    {
        Gate::authorize(StagePermission::List);
        $schools = $this->schoolService->list();

        return new StageCollection($schools);
    }


    public function store(StageStoreRequest $request): StageResource
    {
//        Gate::authorize(StagePermission::Create);
        $schoolDto = StageDto::fromRequest($request);
        $school = $this->schoolService->store($schoolDto);
        return new StageResource($school);
    }

    public function show(Stage $school)
    {
        Gate::authorize(StagePermission::View);


        return new StageResource($school);
    }

    public function update(Stage $school, StageUpdateRequest $request): StageResource
    {
        Gate::authorize(StagePermission::Update);


        $schoolDto = StageDto::fromRequest($request);
        $school = $this->schoolService->update($school, $schoolDto);
        return new StageResource($school);
    }

    public function updateStageFromMurqaib()
    {

        return $this->schoolService->updateStageFromMurqaib();


    }
    public function getStagesDeletedFromMurqaib()
    {

        return $this->schoolService->getStagesDeletedFromMurqaib(School::find(1));


    }
}
