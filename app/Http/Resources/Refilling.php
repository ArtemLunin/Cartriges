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
            "completed"   => $this->completed,
            "cartridge" => [
                "id"    => $this->cartridge->id,
            ]
        ];
    }
}
