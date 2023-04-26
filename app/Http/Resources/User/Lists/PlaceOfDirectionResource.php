<?php

namespace App\Http\Resources\User\Lists;

use Illuminate\Http\Resources\Json\JsonResource;

class PlaceOfDirectionResource extends JsonResource
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
            'organization' => $this->whenLoaded('organization'),
            'name' => $this->name
        ];
    }
}
