<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'sometimes|nullable|string|max:255',
            'address_line_3' => 'sometimes|nullable|string|max:255',
            'address_line_4' => 'sometimes|nullable|string|max:255',
            'post_code' => 'required|string|max:255',
            'site_rooms' => 'required|array|min:1',
            'site_rooms.*.id' => 'sometimes',
            'site_rooms.*.name' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The site name is required.',
            'site_rooms.required' => 'At least one room is required.',
            'site_rooms.*.name.required' => 'The site room field is required.',
            'site_rooms.*.name.max' => 'The site room name must not exceed 255 characters.',
        ];
    }
}