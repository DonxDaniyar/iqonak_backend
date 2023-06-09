<?php

namespace App\Http\Resources\User;

use App\Models\UserInstructionAccept;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'iin' => $this->iin,
            'roles' => $this->whenLoaded('roles'),
            'is_signed' => $this->when($this->roles->contains('name', 'user'), UserInstructionAccept::where('user_id', $this->id)->exists()),
            'organizations' => $this->whenLoaded('organizations')
        ];
    }
}
