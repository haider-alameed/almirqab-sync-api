<?php

namespace App\Http\Requests\Class;

use Illuminate\Foundation\Http\FormRequest;


class ClassStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'mongoId' => 'required|string|max:255',
            'almirqabId' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'postfix' => 'required|string|max:255',
            'fullTitle' => 'required|string|max:255',
            'nameEn' => 'required|string|max:255',
            'fullTitleEn' => 'required|string|max:255',
            'fee' => 'required|string|max:255',


        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => __('name Required'),

        ];
    }
}
