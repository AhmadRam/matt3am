<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'first_name'        => $this->first_name,
            'last_name'         => $this->last_name,
            'gender'            => $this->gender,
            'date_of_birth'     => $this->date_of_birth,
            'email'             => $this->email,
            'phone_code'        => $this->phone_code,
            'phone'             => $this->phone,
            'image'             => $this->image,
            'is_verified'       => $this->is_verified,
            'notes'             => $this->notes,
            'api_token'         => $this->api_token,
            'customer_group'    => new CustomerGroupResource($this->whenLoaded('customerGroup')),
            'created_at'        => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at'        => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
