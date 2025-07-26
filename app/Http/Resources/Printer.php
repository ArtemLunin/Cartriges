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
        // return parent::toArray($request);
        // dd($this);
        return [
            "id"    => $this->id,
            "model" => $this->model,
            "comment"   => $this->comment,
            "place" => [
                "id"    => $this->place->id,
                "place_name"    => $this->place->place_name
            ]
        ];
    }
}
