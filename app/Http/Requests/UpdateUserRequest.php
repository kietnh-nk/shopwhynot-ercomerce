<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        return [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'birthday' => 'nullable|date|before_or_equal:today', // ✅ ngăn ngày sinh tương lai
            'user_catalogue_id' => 'required|exists:user_catalogues,id',
            'publish' => 'nullable|boolean',
            'address' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'birthday.before_or_equal' => 'Ngày sinh không được ở tương lai.',
        ];
    }
}
