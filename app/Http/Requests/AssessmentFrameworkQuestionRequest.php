<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssessmentFrameworkQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'question_type' => 'required|string|max:255',
            'question_options' => 'required|array|min:1',
            'question_options.*.id' => 'sometimes',
            'question_options.*.name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The question name is required.',
            'question_options.required' => 'At least one answer is required.',
            'question_options.*.name.required' => 'The answer field is required.',
            'question_options.*.name.max' => 'The answer must not exceed 255 characters.',
        ];
    }
}