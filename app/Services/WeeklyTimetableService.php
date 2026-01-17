<?php

namespace App\Services;

use App\Models\Classes;
use App\Models\Course;
use App\Models\School;
use App\Models\Stage;
use App\Models\WeeklyTimetable;
use App\Support\MongoObjectId;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\PersonService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class WeeklyTimetableService
{
    public function __construct(private SchoolService $schoolService,
                                private PersonService $personService
    )
    {
    }

    public function getWeeklyTimetablesFromMurqap($school, $classId): array
    {
        Log::info("getWeeklyTimetablesFromMurqap");
        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get("/api/admin/weekly-timetable/$classId");

        Log::info($res);
        Log::info($res);
        $res->throw();
        $data = $res->json();
        Log::info($data);
        return $data["data"];
    }


    public function updateWeeklyTimetableFromMurqaib()
    {
        Log::info('updateWeeklyTimetableFromMurqaib');

        $school = School::findOrFail(1);
        $classes = Classes::where('school_id', $school->id)->get();

        DB::transaction(function () use ($school, $classes) {

            foreach ($classes as $class) {
                Log::info('Class almirqab_id: ' . $class->almirqab_id);

                $items = $this->getWeeklyTimetablesFromMurqap($school, $class->almirqab_id);

                if (!is_iterable($items)) {
                    continue;
                }

                foreach ($items as $item) {
                    Log::info($item);
                    $almirqabId = (int)data_get($item, 'id');

                    $weeklyTimetable = WeeklyTimetable::firstOrNew([
                        'almirqab_id' => $almirqabId,
                    ]);

                    // set mongo_id only if it's empty
                    if (empty($weeklyTimetable->mongo_id)) {
                        $weeklyTimetable->mongo_id = MongoObjectId::generate();
                    }
                    $classes = Classes::firstWhere('almirqab_id', (int) data_get($item, 'class_id'));
                    $course = Course::firstWhere('almirqab_id', (int) data_get($item, 'course_id'));

                    $weeklyTimetable->fill([
                        'almirqab_id' => $almirqabId,
                        'school_id' => $school->id,
                        'day' => data_get($item, 'day'),
                        'order' => data_get($item, 'order'),
                        'class_id' => $classes->id,
                        'course_id' => $course->id,
                    ]);

                    $weeklyTimetable->save();
                }
            }
            return response()->json(['status' => 'ok']);
        });


    }


}
