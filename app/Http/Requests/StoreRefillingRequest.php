<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRefillingRequest extends FormRequest
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
            'date_dispatch' => 'required|date|date_format:Y-m-d',
            'date_receipt'  => 'nullable|date|date_format:Y-m-d',
            'completed' => 'nullable|boolean',
            'cartridge_id' => 'required|exists:cartridges,id',
        ];
    }
}
