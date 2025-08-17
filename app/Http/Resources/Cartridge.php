<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Cartridge extends JsonResource
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
            "barcode"   => $this->barcode,
            "comment"   => $this->comment,
            "working"   => $this->working,
            "place" => [
                "id"    => $this->place->id,
                "place_name"    => $this->place->place_name
            ],
            "model" => [
                "id"    => $this->model->id,
                "model"    => $this->model->model
            ]
        ];
    }
}
