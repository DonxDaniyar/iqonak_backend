<?php

namespace App\Http\Resources\Record;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'organization_id' => $this->organization_id,
            'organization' => $this->whenLoaded('organization'),
            'vehicle_id' => $this->vehicle_id,
            'vehicle' => $this->whenLoaded('vehicle'),
            'visit_purpose_id' => $this->visit_purpose_id,
            'visit_purpose' => $this->whenLoaded('visit_purpose'),
            'place_of_direction_id' => $this->place_of_direction_id,
            'place_of_direction' => $this->whenLoaded('place_of_direction'),
            'payment_note_id' => $this->payment_note_id,
            'payment_note' => $this->whenLoaded('payment_note'),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'manager_id' => $this->manager_id,
            'manager' => UserResource::make($this->whenLoaded('manager')),
            'manager_price' => $this->manager_price,
            'scanned_at' => $this->scanned_at,
            'record_uuid' => $this->record_uuid,
            'checkpoint_id' => $this->checkpoint_id,
            'checkpoint' => $this->whenLoaded('checkpoint_id'),
            'tenure' => $this->tenure
        ];
    }
}
