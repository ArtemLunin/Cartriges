<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartridgeRequest extends FormRequest
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
            'barcode' => 'string|max:10|unique:cartridges,barcode,' . $this->route('cartridge')->id,
            'comment'   => 'nullable|string',
            'working' => 'nullable|integer|min:0',
            'place_id' => 'required|exists:places,id',
            'model_id' => 'required|exists:cartridge_models,id'
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'place_id' => $this->input('place_id', $this->route('cartridge')->place_id),
            'model_id' => $this->input('model_id', $this->route('cartridge')->model_id),
        ]);
    }
}
