<?php

namespace App\Http\Resources\User\Lists;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'name' => $this->name,
            'is_required' => $this->is_required,
            'prices' => TariffResource::collection($this->whenLoaded('tariffs')),
            'price' => $this->when($this->is_required, function (){
                $sum = 0;
                foreach ($this->tariffs as $tariff){
                    $sum += $tariff->price;
                }
                return (float)$sum;
            })
        ];
    }
}
