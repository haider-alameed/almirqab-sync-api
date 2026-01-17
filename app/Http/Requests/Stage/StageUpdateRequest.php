<?php

namespace App\Http\Requests\Stage;

use Illuminate\Foundation\Http\FormRequest;


class StageUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mongoId' => 'required|string|max:255',
            'almirqabId' => 'required|string|max:255',
            'stageId' => 'required|string|max:255',
            'supervisorId' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'classTitle' => 'required|string|max:255',
            'fullTitle' => 'required|string|max:255',
            'studentsCount' => 'required|string|max:255',
            'timetableCount' => 'required|string|max:255',


        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => __('name Required'),

        ];
    }
}
