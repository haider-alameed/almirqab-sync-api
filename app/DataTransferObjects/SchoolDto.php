<?php

namespace App\DataTransferObjects;

use Illuminate\Foundation\Http\FormRequest;

readonly class SchoolDto
{
    public function __construct(
        public string $mongoId,
        public string $name,
        public string $image,
        public string $closestPoint,
        public string $managerName,
        public string $managerPhone,
        public string $directorate,
        public string $governorate,
        public string $groupName,
        public string $gander,
        public string $active,


    )
    {
    }

    public static function fromRequest(FormRequest $request): self
    {


        return new self(
            mongoId: $request->validated('mongoId'),
            name: $request->validated('name'),
            image: $request->validated('image'),
            closestPoint: $request->validated('closestPoint'),
            managerName: $request->validated('managerName'),
            managerPhone: $request->validated('managerPhone'),
            directorate: $request->validated('directorate'),
            governorate: $request->validated('governorate'),
            groupName: $request->validated('groupName'),
            gander: $request->validated('gander'),
            active: $request->validated('active'),


        );
    }
}
