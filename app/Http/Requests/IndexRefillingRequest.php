<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class IndexRefillingRequest extends FormRequest
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
            'month' => 'nullable|integer|min:1|max:12',
            'year'  => 'nullable|integer|min:2020|max:2120',
        ];
    }

    protected function prepareForValidation(): void
    {
        $date_obj = Carbon::today();
        $month = $date_obj->format('n');
        $year = $date_obj->format('Y');
        if($this->filled('month') && $this->input('month') === 'prev') {
            $date_prev = $date_obj->subMonth();
            $month = $date_prev->format('n');
            $year = $date_prev->format('Y');
            $this->merge([
                'month' => $month,
                'year' => $year,
            ]);
        } elseif ($this->filled('month'))
        {
            $this->merge([
                'month' => $this->input('month', $month),
                'year' => $this->input('year', $year),
            ]);
        }
    }
}
