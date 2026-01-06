<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\TeacherDto;
use App\Enums\Permissions\TeacherPermission;

use App\Http\Requests\Teacher\TeacherStoreRequest;
use App\Http\Requests\Teacher\TeacherUpdateRequest;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use App\Services\TeacherService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TeacherController extends Controller
{
    public function __construct(private readonly TeacherService $teacherService)
    {
    }


    public function index(Request $request): TeacherCollection
    {

    }

    public function list(): TeacherCollection
    {

    }


    public function store(TeacherStoreRequest $request): TeacherResource
    {

    }

    public function show(Teacher $school)
    {

    }

    public function update(Teacher $school, TeacherUpdateRequest $request): TeacherResource
    {
    }


    public function updateTeacherFromMurqaib()
    {

        return $this->teacherService->updateTeacherFromMurqaib();


    }
}
