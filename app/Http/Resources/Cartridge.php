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
        ];
        if (!str_contains($request->path(), 'cartridge-models')) {
            $data['model'] = $this->whenLoaded('model', fn() => [
            // $data['model'] = [
                'id' => $this->model->id,
                'model' => $this->model->model,
            ],1);
        }
        if (!str_contains($request->path(), 'places')) {
            $data['place'] = $this->whenLoaded('place', fn() => [
                // $data['place'] = [
                "id"    => $this->place->id,
                "place_name"    => $this->place->place_name
            ]);
        }
        return $data;
    }
}
