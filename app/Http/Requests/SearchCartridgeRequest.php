<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchCartridgeRequest extends FormRequest
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
            'query' => 'required|string|min:3',
        ];
    }

    public function messages(): array
    {
        return [
            'query.required' => 'Параметр поиска обязателен.',
            'query.min' => 'Параметр поиска должен содержать минимум 3 символа.',
        ];
    }
}
