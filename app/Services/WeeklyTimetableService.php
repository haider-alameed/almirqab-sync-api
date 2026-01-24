<?php

namespace App\Services;

use App\Models\Classes;
use App\Models\Course;

use App\Models\WeeklyTimetable;
use App\Support\MongoObjectId;
use App\Support\SyncHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get("/api/admin/weekly-timetable/$classId");


        $res->throw();
        $data = $res->json();

        return $data["data"];
    }


    public function updateWeeklyTimetableFromMurqaib($school,$dateFetch):array|string
    {

        $classes = Classes::where('school_id', $school->id)->get();

        DB::transaction(function () use ($school, $classes,$dateFetch) {

            foreach ($classes as $class) {
                $items = $this->getWeeklyTimetablesFromMurqap($school, $class->almirqab_id);

                if (!is_iterable($items)) {
                    continue;
                }

                foreach ($items as $item) {
                    if (! SyncHelper::shouldSyncByUpdatedAt($item, $dateFetch)) {
                        logger()->info('classes not updated', ['almirqab_id' => $r['id'] ?? null]);
                        continue;
                    }

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

        return response()->json(['status' => 'NotOk']);
    }
    public function getTimetableDeletedFromMurqaib($school): array|string
    {

        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/deleted-report');


        $res->throw();
        $data = $res->json();
        $ids = collect($data['data']['timetable'] ?? [])
            ->pluck('id')
            ->filter()
            ->unique()
            ->values();

        if ($ids->isNotEmpty()) {
            WeeklyTimetable::whereIn('almirqab_id', $ids)->delete();
        }
        return "success";
    }

}
