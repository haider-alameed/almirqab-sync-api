<?php

namespace App\Services;

use App\DataTransferObjects\CourseDto;
use App\Filters\CourseFilter;
use App\Models\Classes;
use App\Models\School;
use App\Models\Course;

use App\Support\MongoObjectId;
use App\Support\SyncHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class CourseService
{
    public function __construct(private SchoolService $schoolService)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $perPage = $request->get('perPage', 25);
        $filter = resolve(CourseFilter::class);
        $query = Course::orderBy('order')->useFilter($filter);
        return $query->paginate($perPage);
    }

    public function list(): Collection
    {
        $filter = resolve(CourseFilter::class);

        return Course::
        with([])
            ->orderBy('order')
            ->useFilter($filter)
            ->get();
    }


    public function store(CourseDto $courseDto): Course
    {

        return DB::transaction(function () use ($courseDto) {
            $course = Course::create([
                'mongo_id' => $courseDto->mongoId,
                'almirqab_id' => $courseDto->almirqabId,
                'name' => $courseDto->name,
                'postfix' => $courseDto->postfix,
                'full_title' => $courseDto->fullTitle,
                'name_en' => $courseDto->nameEn,
                'full_title_en' => $courseDto->fullTitleEn,
                'fee' => $courseDto->fee,
            ]);

            return $course;
        });
    }

    public function update(Course $course, CourseDto $courseDto): Course
    {

        return DB::transaction(function () use ($course, $courseDto) {
            $course->update([
                'mongo_id' => $courseDto->mongoId,
                'almirqab_id' => $courseDto->mongoId,
                'name' => $courseDto->almirqabId,
                'postfix' => $courseDto->name,
                'full_title' => $courseDto->postfix,
                'name_en' => $courseDto->fullTitle,
                'full_title_en' => $courseDto->nameEn,
                'fee' => $courseDto->fullTitleEn,
            ]);

            return $course;
        });
    }


    public function getCourseInfo($school): array
    {

        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/course/courses');
        Log::info($res);


        $res->throw();
        $data = $res->json();
        return $data["data"];
    }


    public function updateCourseFromMurqaib($school,$dateFetch)
    {


        $rows = $this->getCourseInfo($school);


        foreach ($rows as $r) {
            if (! SyncHelper::shouldSyncByUpdatedAt($r, $dateFetch)) {
                logger()->info('classes not updated', ['almirqab_id' => $r['id'] ?? null]);
                continue;
            }
            $course = Course::firstOrNew(['almirqab_id' => $r['id']]);

            $course->mongo_id ??= MongoObjectId::generate();

            $course->fill([
                'almirqab_id' => $r['id'] ?? null,
                'school_id' => $school->id,
                'order' => $r['order'] ?? null,
                'title' => $r['title'] ?? null,
            ]);

            $course->save();
        }


        return $rows;
    }
    public function getCoursesDeletedFromMurqaib($school): array|string
    {

        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/deleted-report');


        $res->throw();
        $data = $res->json();
        $ids = collect($data['data']['courses'] ?? [])
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
