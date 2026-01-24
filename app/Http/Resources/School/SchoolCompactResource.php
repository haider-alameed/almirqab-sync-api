<?php

namespace App\Http\Resources\School;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolCompactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            '_id'        => (string) ($this->mongo_id ?? $this->_id ?? ''),
            'schoolId'   => $this->id,
            'schoolName' => $this->name,
            'GroupName'  => $this->group_name,
            'GroupId'    => $this->group_id ?? null,
            'isActive'   => (bool) $this->active,
            'gander'     => (bool) $this->gander,
        ];
    }
}
