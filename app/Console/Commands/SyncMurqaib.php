<?php

namespace App\Console\Commands;

use App\Models\FetchRun;
use App\Models\School;
use App\Services\SchoolService;
use Illuminate\Console\Command;
use Throwable;

use App\Services\ClassService;
use App\Services\CourseService;
use App\Services\LoginAlmirqabService;
use App\Services\PersonService;
use App\Services\StageService;
use App\Services\TeacherService;
use App\Services\WeeklyTimetableService;

class SyncMurqaib extends Command
{
    protected $signature = 'sync:murqaib';
    protected $description = 'Sync data from Murqaib/Almirqab APIs';

    public function __construct(
        protected SchoolService $schoolService,
        protected ClassService $classService,
        protected StageService $stageService,
        protected TeacherService $teacherService,
        protected PersonService $personService,
        protected CourseService $courseService,
        protected WeeklyTimetableService $weeklyTimetableService,
        protected LoginAlmirqabService $loginAlmirqabService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {

        $schools =  School::query()->get();
        $lastFetch = FetchRun::query()
            ->latest('started_at')
            ->value('started_at');

        $lastFetch = $lastFetch ? \Carbon\Carbon::parse($lastFetch) : null;


        foreach ($schools as $school) {

            $run = FetchRun::create([
                'source'     => "murqaib:school:{$school->id}",
                'started_at' => now(),
                'status'     => 'running',
                'items_count'=> 0,
            ]);

            try {

                $school = $this->schoolService->updateSchoolFromMurqaib($school);
                //classes

                $classes = $this->classService->updateClassFromMurqaib($school,$lastFetch);
                $this->classService->getClassesDeletedFromMurqaib($school);

                //stages
                $stages = $this->stageService->updateStageFromMurqaib($school);
                $this->stageService->getStagesDeletedFromMurqaib($school);

                //courses
                $courses = $this->courseService->updateCourseFromMurqaib($school,$lastFetch);
                $this->courseService->getCoursesDeletedFromMurqaib($school);

                //courses
                $courses = $this->courseService->updateCourseFromMurqaib($school,$lastFetch);
                $this->courseService->getCoursesDeletedFromMurqaib($school);


                //teachers
                $teachers = $this->teacherService->updateTeacherFromMurqaib($school,$lastFetch);
                $this->teacherService->getTeacherDeletedFromMurqaib($school);



                //weeklyTimetable
                $weeklyTimetable = $this->weeklyTimetableService->updateWeeklyTimetableFromMurqaib($school,$lastFetch);
                $this->weeklyTimetableService->getTimetableDeletedFromMurqaib($school);



                $run->update([
                    'finished_at' => now(),
                    'items_count' => 0,
                    'status'      => 'success',
                ]);

                $this->info("School {$school->id} synced successfully.");
            } catch (Throwable $e) {
                $run->update([
                    'finished_at' => now(),
                    'status'      => 'failed',
                    'error'       => $e->getMessage(),
                ]);

                report($e);
                $this->error("School {$school->id} failed: ".$e->getMessage());
            }
        }

        return self::SUCCESS;
    }
}
