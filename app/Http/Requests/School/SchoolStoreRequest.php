<?php

namespace App\Http\Requests\School;

use Illuminate\Foundation\Http\FormRequest;


class SchoolStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mongoId' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'closestPoint' => 'required|string|max:255',
            'managerName' => 'required|string|max:255',
            'managerPhone' => 'required|string|max:255',
            'directorate' => 'required|string|max:255',
            'governorate' => 'required|string|max:255',
            'groupName' => 'required|string|max:255',
            'gander' => 'required|string|max:255',
            'active' => 'required|string|max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => __('name Required'),

        ];
    }
}
