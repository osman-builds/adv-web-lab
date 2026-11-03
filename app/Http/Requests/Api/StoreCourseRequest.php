<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:10', 'unique:courses,code'],
            'name' => ['required', 'string', 'max:255'],
            'credit_hours' => ['required', 'integer', 'between:1,6'],
        ];
    }
}
