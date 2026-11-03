<?php

namespace App\Http\Requests\Api;

use Illuminate\Validation\Rule;

class UpdateCourseRequest extends StoreCourseRequest
{
    public function rules(): array
    {
        return [
            // 'sometimes' = validate only if the field is sent (allows PATCH with one field)
            'code' => [
                'sometimes',
                'required',
                'string',
                'max:10',
                Rule::unique('courses', 'code')->ignore($this->route('course')),
            ],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'credit_hours' => ['sometimes', 'required', 'integer', 'between:1,6'],
        ];
    }
}
