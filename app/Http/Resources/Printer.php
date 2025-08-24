<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Printer extends JsonResource
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
            "model" => $this->model,
            "comment"   => $this->comment,
            "place_id" => $this->place->id,
            "place_name" => $this->place->place_name,
        ];
    }
}
