<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
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
            'id'              => $this->id,
            'name'            => $this->name,
            'title'           => $this->title,
            'rating'          => $this->rating,
            'comment'         => $this->comment,
            'status'          => $this->status,
            'customer_id'     => $this->customer_id,
            'product_id'      => $this->product_id,
            'created_at'      => \Carbon\Carbon::parse($this->created_at)->format('Y/m/d H:i:s'),
            'updated_at'      => \Carbon\Carbon::parse($this->updated_at)->format('Y/m/d H:i:s'),
        ];
    }
}
