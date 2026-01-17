<?php

namespace App\Services;

use App\DataTransferObjects\StageDto;
use App\Filters\StageFilter;
use App\Models\School;
use App\Models\Stage;

use App\Support\MongoObjectId;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class StageService
{
    public function __construct(private SchoolService $schoolService)
    {
    }

    public function index(Request $request): LengthAwarePaginator
    {
        $perPage = $request->get('perPage', 25);
        $filter = resolve(StageFilter::class);
        $query = Stage::orderBy('order')->useFilter($filter);
        return $query->paginate($perPage);
    }

    public function list(): Collection
    {
        $filter = resolve(StageFilter::class);

        return Stage::
        with([])
            ->orderBy('order')
            ->useFilter($filter)
            ->get();
    }


    public function store(StageDto $stageDto): Stage
    {

        return DB::transaction(function () use ($stageDto) {
            $stage = Stage::create([
                'mongo_id' => $stageDto->mongoId,
                'almirqab_id' => $stageDto->almirqabId,
                'name' => $stageDto->name,
                'postfix' => $stageDto->postfix,
                'full_title' => $stageDto->fullTitle,
                'name_en' => $stageDto->nameEn,
                'full_title_en' => $stageDto->fullTitleEn,
                'fee' => $stageDto->fee,
            ]);

            return $stage;
        });
    }

    public function update(Stage $stage, StageDto $stageDto): Stage
    {

        return DB::transaction(function () use ($stage, $stageDto) {
            $stage->update([
                'mongo_id' => $stageDto->mongoId,
                'almirqab_id' => $stageDto->mongoId,
                'name' => $stageDto->almirqabId,
                'postfix' => $stageDto->name,
                'full_title' => $stageDto->postfix,
                'name_en' => $stageDto->fullTitle,
                'full_title_en' => $stageDto->nameEn,
                'fee' => $stageDto->fullTitleEn,
            ]);

            return $stage;
        });
    }


    public function getStageInfo($school): array
    {

        $token = $this->schoolService->getToken($school);

        $res = Http::baseUrl($school->base_url)
            ->acceptJson()
            ->withToken($token)
            ->get('/api/admin/class/stages');
        Log::info($res);


        $res->throw();
        $data = $res->json();
        return $data["data"];
    }


    public function updateStageFromMurqaib()
    {
        $id = 1;

        $school = School::findOrFail($id);

        $rows = $this->getStageInfo($school);


        foreach ($rows as $r) {
            $stage = Stage::firstOrNew(['almirqab_id' => $r['id']]);

            $stage->mongo_id ??= MongoObjectId::generate();

            $stage->fill([
                'name'          => $r['name'] ?? null,
                'school_id'          => $school->id,
                'postfix'       => $r['postfix'] ?? null,
                'full_title'    => $r['full_title'] ?? null,
                'name_en'       => $r['name_en'] ?? null,
                'full_title_en' => $r['full_title_en'] ?? null,
                'fee'           => $r['fee'] ?? null,
            ]);

            $stage->save();
        }


        return $rows;
    }


}
