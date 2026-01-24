<?php

namespace App\Services;

use App\Models\School;
use App\Models\Stage;
use App\Models\Teacher;
use App\Models\Year;
use App\Support\MongoObjectId;
use App\Support\SyncHelper;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\PersonService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TeacherService
{
    public function __construct(private SchoolService $schoolService,
                                private PersonService $personService
    )
    {
    }

    public function getTeachersFromMurqap($school): array
    {
        Log::info("dddddddddddddddddddddddddd");
        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/teacher');

        Log::info($res);
        Log::info($res);
        $res->throw();
        $data = $res->json();
        return $data["data"];
    }


    public function updateTeacherFromMurqaib($school,$dateFetch)
    {


        $rows = $this->getTeachersFromMurqap($school);

        DB::transaction(function () use ($rows,$school,$dateFetch) {
            Log::info('---------------------------------');
            foreach ($rows as $r) {

                if (empty($r['person'])) {
                    continue;
                }
                if (! SyncHelper::shouldSyncByUpdatedAt($r, $dateFetch)) {
                    logger()->info('classes not updated', ['almirqab_id' => $r['id'] ?? null]);
                    continue;
                }
                // 1) Person insert/update in PersonService
                $person = $this->personService->upsertFromMurqaib($r['person'],$school->id);

                // 2) Teacher insert/update
                // Recommended: add teachers.almirqab_id (external teacher id) and unique it
                $teacher = Teacher::firstOrNew(['almirqab_id' => (int)$r['id']]);

                $year = Year::firstWhere('almirqab_id', (int) $r['year_id']);
                Log::info('year_id');
                Log::info($r['year_id']);
                $teacher->mongo_id ??= MongoObjectId::generate();

                $teacher->fill([
                    'school_id' => $school->id,
                    'person_id' => $person->id,
                    'year_id' => $year->id ?? null, // only if FK is correct to years table
                    'migrated' => (bool)($r['migrated'] ?? false),
                    'app_state' => (int)($r['app_state'] ?? 1),
                    'state_date' => !empty($r['state_date']) ? Carbon::parse($r['state_date']) : null,
                    'teacher_in_api' => true,
                    'gender' => $r['person']['gender'] ?? null,
                    'image' => $r['image']['original_url'] ?? null,
                    'mongo_created_at' => !empty($r['created_at']) ? Carbon::parse($r['created_at']) : null,
                    'mongo_updated_at' => !empty($r['updated_at']) ? Carbon::parse($r['updated_at']) : null,
                ]);

                $teacher->save();
            }
        });

        return $rows;
    }
    public function getTeacherDeletedFromMurqaib($school): array|string
    {

        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/deleted-report');


        $res->throw();
        $data = $res->json();
        $ids = collect($data['data']['teachers'] ?? [])
            ->pluck('id')
            ->filter()
            ->unique()
            ->values();

        if ($ids->isNotEmpty()) {
            Teacher::whereIn('almirqab_id', $ids)->delete();
        }
        return "success";
    }
}
