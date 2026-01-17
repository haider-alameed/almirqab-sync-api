<?php

namespace App\DataTransferObjects;

use Illuminate\Foundation\Http\FormRequest;

readonly class ClassDto
{
    public function __construct(
        public int $id,
        public string $mongoId,
        public string $almirqabId,
        public string $stageId,
        public string $supervisorId,
        public string $title,
        public string $classTitle,
        public string $fullTitle,
        public string $studentsCount,
        public string $timetableCount,


    )
    {
    }

    public static function fromRequest(FormRequest $request): self
    {


        return new self(
            id: $request->validated('id'),
            mongoId: $request->validated('mongoId'),
            almirqabId: $request->validated('almirqabId'),
            stageId: $request->validated('stageId'),
            supervisorId: $request->validated('supervisorId'),
            title: $request->validated('title'),
            classTitle: $request->validated('classTitle'),
            fullTitle: $request->validated('fullTitle'),
            studentsCount: $request->validated('studentsCount'),
            timetableCount: $request->validated('timetableCount'),

        );
    }
}
