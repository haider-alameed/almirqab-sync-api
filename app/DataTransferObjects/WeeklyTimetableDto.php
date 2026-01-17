<?php

namespace App\DataTransferObjects;

use Illuminate\Foundation\Http\FormRequest;

readonly class WeeklyTimetableDto
{
    public function __construct(
        public int $id,
        public string $mongoId,
        public string $almirqabId,
        public string $name,
        public string $postfix,
        public string $fullTitle,
        public string $nameEn,
        public string $fullTitleEn,
        public string $fee,
    )
    {
    }

    public static function fromRequest(FormRequest $request): self
    {


        return new self(
            id: $request->validated('id'),
            mongoId: $request->validated('mongoId'),
            almirqabId: $request->validated('almirqabId'),
            name: $request->validated('name'),
            postfix: $request->validated('postfix'),
            fullTitle: $request->validated('fullTitle'),
            nameEn: $request->validated('nameEn'),
            fullTitleEn: $request->validated('fullTitleEn'),
            fee: $request->validated('fee'),

        );
    }
}
