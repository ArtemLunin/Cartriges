<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartridgeModel extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd($this->cartridges);
        return [
            "id"    => $this->id,
            "model" => $this->model,
            "capacity"   => $this->capacity,
            "cost"  => $this->cost,
            "cartridges" => Cartridge::collection($this->cartridges)
        ];
    }
}
