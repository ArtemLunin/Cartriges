<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartridgeModelRequest extends FormRequest
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
            'model' => 'required|unique:cartridge_models,model|string|max:50',
            'capacity' => 'nullable|integer|min:0',
            'cost' => 'nullable|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'model.unique' => 'Такая модель картриджа уже существует',
            // 'query.min' => 'Параметр поиска должен содержать минимум 3 символа.',
        ];
    }
}
