<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Refilling extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"    => $this->id,
            "date_dispatch"   => $this->date_dispatch?->toDateString(),
            "date_receipt"   => $this->date_receipt?->toDateString(),
            "completed"     => $this->completed,
            "cartridge_id"  => $this->cartridge->id,
            "cartridge_barcode"  => $this->cartridge->barcode,
            "model_id"      => $this->cartridge->model->id,
            "model_model"   => $this->cartridge->model->model,
            "capacity"      => $this->cartridge->model->capacity,
            "cost"          => $this->cartridge->model->cost
        ];
    }
}
