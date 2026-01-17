<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\ClassDto;
use App\Enums\Permissions\ClassPermission;

use App\Http\Requests\Class\ClassStoreRequest;
use App\Http\Requests\Class\ClassUpdateRequest;
use App\Http\Resources\ClassCollection;
use App\Http\Resources\ClassResource;
use App\Models\Classes;
use App\Services\ClassService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ClassController extends Controller
{
    public function __construct(private readonly ClassService $classService)
    {
    }

    public function index(Request $request): ClassCollection
    {
        Gate::authorize(ClassPermission::Index);
        $schools = $this->classService->index($request);

        return new ClassCollection($schools);
    }

    public function list(): ClassCollection
    {
        Gate::authorize(ClassPermission::List);
        $schools = $this->classService->list();

        return new ClassCollection($schools);
    }


    public function store(ClassStoreRequest $request): ClassResource
    {
//        Gate::authorize(ClassPermission::Create);
        $schoolDto = ClassDto::fromRequest($request);
        $school = $this->classService->store($schoolDto);
        return new ClassResource($school);
    }

    public function show(Classes $school)
    {
        Gate::authorize(ClassPermission::View);


        return new ClassResource($school);
    }

    public function update(Classes $school, ClassUpdateRequest $request): ClassResource
    {
        Gate::authorize(ClassPermission::Update);


        $schoolDto = ClassDto::fromRequest($request);
        $school = $this->classService->update($school, $schoolDto);
        return new ClassResource($school);
    }

    public function updateClassFromMurqaib()
    {

        return $this->classService->updateClassFromMurqaib();


    }
}
