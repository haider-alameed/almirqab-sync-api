<?php

namespace App\Http\Controllers;

use App\DataTransferObjects\WeeklyTimetableDto;
use App\Enums\Permissions\WeeklyTimetablePermission;

use App\Http\Requests\WeeklyTimetable\WeeklyTimetableStoreRequest;
use App\Http\Requests\WeeklyTimetable\WeeklyTimetableUpdateRequest;
use App\Http\Resources\WeeklyTimetableCollection;
use App\Http\Resources\WeeklyTimetableResource;
use App\Models\WeeklyTimetable;
use App\Services\WeeklyTimetableService;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class WeeklyTimetableController extends Controller
{
    public function __construct(private readonly WeeklyTimetableService $weeklyTimetableService)
    {
    }


    public function index(Request $request): WeeklyTimetableCollection
    {

    }

    public function list(): WeeklyTimetableCollection
    {

    }


    public function store(WeeklyTimetableStoreRequest $request): WeeklyTimetableResource
    {

    }

    public function show(WeeklyTimetable $school)
    {

    }

    public function update(WeeklyTimetable $school, WeeklyTimetableUpdateRequest $request): WeeklyTimetableResource
    {
    }


    public function updateWeeklyTimetableFromMurqaib()
    {

        return $this->weeklyTimetableService->updateWeeklyTimetableFromMurqaib();


    }
}
