<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mongoId' => $this->mongo_id,
            'almirqabId' => $this->almirqab_id,
            'stageId' => $this->stage_id,
            'supervisorId' => $this->supervisor_id,
            'title' => $this->title,
            'classTitle' => $this->class_title,
            'fullTitle' => $this->full_title,
            'studentsCount' => $this->students_count,
            'timetableCount' => $this->timetable_count,
        ];
    }
}
