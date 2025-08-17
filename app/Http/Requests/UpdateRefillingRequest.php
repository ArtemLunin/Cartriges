<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class UpdateRefillingRequest extends FormRequest
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
            'date_dispatch' => 'nullable|date|before_or_equal:date_receipt',
            'date_receipt'  => 'required|date',
            'completed' => 'nullable|boolean',
            'cartridge_id' => 'required|exists:cartridges,id',
        ];
    }

    protected function prepareForValidation(): void
    {
        $date_dispatch = Carbon::create($this->route('refilling')->date_dispatch);
        $date_obj = Carbon::today();
        $date_receipt = Carbon::createFromFormat('Y-m-d', $this->input('date_receipt', $date_obj->toDateString()));
        $date_receipt->endOfDay();
        $this->merge([
            'cartridge_id' => $this->input('cartridge_id', $this->route('refilling')->cartridge_id),
            'date_dispatch' => $date_dispatch->toDateString(),
            'date_receipt' => $date_receipt->toDateString(),
            'completed' => true,
        ]);
    }
}
