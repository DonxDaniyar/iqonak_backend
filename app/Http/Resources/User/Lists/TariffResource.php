<?php

namespace App\Http\Resources\User\Lists;

use Illuminate\Http\Resources\Json\JsonResource;

class TariffResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'service' => $this->whenLoaded('service'),
            'price' => $this->price,
            'is_adult' => $this->is_adult,
            'is_student' => $this->is_student,
            'is_kid' => $this->is_kid
        ];
    }
}
