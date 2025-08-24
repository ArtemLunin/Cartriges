<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Place extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"        => $this->id,
            "place_name" => $this->place_name,
            "comment"   => $this->comment,
            "cartridges" => Cartridge::collection($this->cartridges)
        ];
    }
}
