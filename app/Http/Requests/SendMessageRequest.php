<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ownership of the conversation is checked in the controller
    }

    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:1000'],
            'conversation_id' => ['nullable', 'string', 'max:64'],
        ];
    }
}
