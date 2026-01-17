<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'mongoId' => $this->mongo_id,
            'almirqabId' => $this->almirqab_id,
            'name' => $this->name,
            'postfix' => $this->postfix,
            'fullTitle' => $this->full_title,
            'nameEn' => $this->name_en,
            'fullTitleEn' => $this->full_title_en,
            'fee' => $this->fee,

        ];
    }
}
