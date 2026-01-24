<?php

namespace App\Http\Resources\Class;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClassFullResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'mongoId'      => $this->mongo_id,
            'name'         => $this->name,
            'image'        => $this->image,
            'closestPoint' => $this->closest_point,
            'managerName'  => $this->manager_name,
            'managerPhone' => $this->manager_phone,
            'directorate'  => $this->directorate,
            'governorate'  => $this->governorate,
            'groupName'    => $this->group_name,
            'gander'       => $this->gander,
            'active'       => $this->active,
        ];
    }
}
