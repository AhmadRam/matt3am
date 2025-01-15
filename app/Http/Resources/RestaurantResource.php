<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
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
            'id'                   => $this->id,
            'name'                 => $this->name,
            'address'              => $this->address,
            'phone_code'           => $this->phone_code,
            'phone'                => $this->phone,
            'logo'                 => $this->logo,
            'status'               => $this->status,
            'user_id'              => $this->user_id,
            'currency_id'          => $this->currency_id,
            'meta_title'           => $this->meta_title,
            'meta_keywords'        => $this->meta_keywords,
            'meta_description'     => $this->meta_description,
            'subscription_start_date' => \Carbon\Carbon::parse($this->subscription_start_date)->format('Y/m/d'),
            'subscription_end_date'   => \Carbon\Carbon::parse($this->subscription_end_date)->format('Y/m/d'),
            'created_at'           => \Carbon\Carbon::parse($this->created_at)->format('Y/m/d H:i:s'),
            'updated_at'           => \Carbon\Carbon::parse($this->updated_at)->format('Y/m/d H:i:s'),
        ];
    }
}
