<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\CourseDto;
use App\Enums\Permissions\CoursePermission;

use App\Http\Requests\Course\CourseStoreRequest;
use App\Http\Requests\Course\CourseUpdateRequest;
use App\Http\Resources\CourseCollection;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\School;
use App\Services\CourseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function __construct(private readonly CourseService $schoolService)
    {
    }

    public function index(Request $request): CourseCollection
    {
        Gate::authorize(CoursePermission::Index);
        $schools = $this->schoolService->index($request);

        return new CourseCollection($schools);
    }

    public function list(): CourseCollection
    {
        Gate::authorize(CoursePermission::List);
        $schools = $this->schoolService->list();

        return new CourseCollection($schools);
    }


    public function store(CourseStoreRequest $request): CourseResource
    {
//        Gate::authorize(CoursePermission::Create);
        $schoolDto = CourseDto::fromRequest($request);
        $school = $this->schoolService->store($schoolDto);
        return new CourseResource($school);
    }

    public function show(Course $school)
    {
        Gate::authorize(CoursePermission::View);


        return new CourseResource($school);
    }

    public function update(Course $school, CourseUpdateRequest $request): CourseResource
    {
        Gate::authorize(CoursePermission::Update);


        $schoolDto = CourseDto::fromRequest($request);
        $school = $this->schoolService->update($school, $schoolDto);
        return new CourseResource($school);
    }

    public function updateCourseFromMurqaib()
    {

        return $this->schoolService->updateCourseFromMurqaib();


    }
    public function getCoursesDeletedFromMurqaib()
    {

        return $this->schoolService->getCoursesDeletedFromMurqaib(School::find(1));


    }
}
