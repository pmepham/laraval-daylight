<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $decryptedId = $this->attributes->get('decrypted_id');
        $emailRule = Rule::unique('users', 'email');
        if ($decryptedId) {
            $emailRule->ignore($decryptedId);
        }

        return [
            'email' => [
                'required',
                'email',
                $emailRule,
            ],
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => 'sometimes|required',
            'permission_level' => 'required',
        ];
    }
}
