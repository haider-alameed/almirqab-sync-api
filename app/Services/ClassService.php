<?php

namespace App\Services;

use App\DataTransferObjects\ClassDto;
use App\Filters\ClassFilter;
use App\Models\Classes;
use App\Models\School;
use App\Models\Stage;
use App\Models\Teacher;
use App\Support\MongoObjectId;
use App\Support\SyncHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class ClassService
{
    public function __construct(private SchoolService $schoolService)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $perPage = $request->get('perPage', 25);
        $filter = resolve(ClassFilter::class);
        $query = Classes::useFilter($filter);
        return $query->paginate($perPage);
    }

    public function list(): Collection
    {
        $filter = resolve(ClassFilter::class);

        return Classes::
        with([])
            ->orderBy('order')
            ->useFilter($filter)
            ->get();
    }


    public function store(ClassDto $classDto): Classes
    {

        return DB::transaction(function () use ($classDto) {
            $class = Classes::create([


                'mongo_id' => $classDto->mongoId,
                'almirqab_id' => $classDto->almirqabId,
                'stage_id' => $classDto->stageId,
                'supervisor_id' => $classDto->supervisorId,
                'title' => $classDto->title,
                'class_title' => $classDto->classTitle,
                'full_title' => $classDto->fullTitle,
                'students_count' => $classDto->studentsCount,
                'timetable_count' => $classDto->timetableCount,
            ]);

            return $class;
        });
    }

    public function update(Classes $class, ClassDto $classDto): Classes
    {

        return DB::transaction(function () use ($class, $classDto) {
            $class->update([
                'mongo_id' => $classDto->mongoId,
                'almirqab_id' => $classDto->almirqabId,
                'stage_id' => $classDto->stageId,
                'supervisor_id' => $classDto->supervisorId,
                'title' => $classDto->title,
                'class_title' => $classDto->classTitle,
                'full_title' => $classDto->fullTitle,
                'students_count' => $classDto->studentsCount,
                'timetable_count' => $classDto->timetableCount,
            ]);

            return $class;
        });
    }


    public function getClassInfo($school): array
    {

        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/class');
        Log::info($res);


        $res->throw();
        $data = $res->json();
        return $data["data"];
    }


    public function updateClassFromMurqaib($school,$dateFetch)
    {


        $rows = $this->getClassInfo($school);


        foreach ($rows as $r) {
            if (! SyncHelper::shouldSyncByUpdatedAt($r, $dateFetch)) {
                logger()->info('classes not updated', ['almirqab_id' => $row['id'] ?? null]);
                continue;
            }
            $class = Classes::firstOrNew(['almirqab_id' => (int)$r['id']]);

            $class->mongo_id ??= MongoObjectId::generate();

            $supervisorId = Teacher::where('almirqab_id', (int)($r['supervisor_id'] ?? 0))->value('id');
            $stageId = Stage::where('almirqab_id', (int)($r['stage_id'] ?? 0))->value('id');

            if (!$stageId) {
                continue; // or throw/log
            }

            $class->fill([
                'almirqab_id' => $r['id'] ?? null,
                'school_id' => $school->id,
                'stage_id' => $stageId,
                'title' => $r['title'] ?? null,
                'supervisor_id' => $supervisorId ?: null,
                'class_title' => $r['class_title'] ?? null,
                'students_count' => $r['students_count'] ?? 0,
                'timetable_count' => $r['timetable_count'] ?? 0,
                'full_title' => $r['full_title'] ?? null,
            ]);

            $class->save();
        }


        return $rows;
    }

    public function getClassesDeletedFromMurqaib($school): array|string
    {

        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/deleted-report');


        $res->throw();
        $data = $res->json();
        $ids = collect($data['data']['classes'] ?? [])
            ->pluck('id')
            ->filter()
            ->unique()
            ->values();

        if ($ids->isNotEmpty()) {
            Classes::whereIn('almirqab_id', $ids)->delete();
        }
        return "success";
    }
}
