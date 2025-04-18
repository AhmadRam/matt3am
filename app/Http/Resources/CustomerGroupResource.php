<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerGroupResource extends JsonResource
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
            'code'              => $this->code,
            'name'              => $this->name,
            'is_user_defined'   => $this->is_user_defined,
            'created_at'        => \Carbon\Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at'        => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
