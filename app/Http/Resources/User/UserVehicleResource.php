<?php

namespace App\Http\Resources\User;

use App\Http\Resources\User\Lists\VehicleTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserVehicleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vehicle_type_id' => $this->vehicle_type_id,
            'vehicle_type' => VehicleTypeResource::make($this->whenLoaded('vehicleType')),
            'value' => $this->car_brand,
            'number' => $this->number
        ];
    }
}
