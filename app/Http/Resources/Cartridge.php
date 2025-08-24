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
        $data = [
            "id"    => $this->id,
            "barcode"   => $this->barcode,
            "comment"   => $this->comment,
            "working"   => $this->working,
            "refillings" => Refilling::collection($this->refillings)
        ];
        if (!str_contains($request->path(), 'cartridge-models')) {
            if ($this->relationLoaded('model')) {
                $data['model_id'] = $this->model->id;
                $data['model'] = $this->model->model;
            }
            // $data['model'] = $this->whenLoaded('model', fn() => [
            //     'id' => $this->model->id,
            //     'model' => $this->model->model,
            // ],1);
        }
        if (!str_contains($request->path(), 'places')) {
            if ($this->relationLoaded('place')) {
                $data['place_id'] = $this->place->id;
                $data['place_name'] = $this->place->place_name;
            }
            // $data['place'] = $this->whenLoaded('place', fn() => [
            //     "id"    => $this->place->id,
            //     "place_name"    => $this->place->place_name
            // ]);
        }
        return $data;
    }
}
