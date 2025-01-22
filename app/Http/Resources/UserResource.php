<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'id'               => $this->id,
            'username'         => $this->username,
            'full_name'        => $this->full_name,
            'email'            => $this->email,
            'status'           => $this->status,
            'profile_image'    => Storage::url($this->profile_image),
            'restaurant_id'    => $this->restaurant_id,
            'token'            => $this->token ?? null,
            'email_verified_at' => \Carbon\Carbon::parse($this->email_verified_at)->format('Y-m-d H:i:s'),
            'created_at'       => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at'       => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
