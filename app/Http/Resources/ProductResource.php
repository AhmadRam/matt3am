<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'sku'                  => $this->sku,
            'name'                 => $this->name,
            'url_key'              => $this->url_key,
            'description'          => $this->description,
            'short_description'    => $this->short_description,
            'meta_title'           => $this->meta_title,
            'meta_keywords'        => $this->meta_keywords,
            'meta_description'     => $this->meta_description,
            'status'               => $this->status,
            'new'                  => $this->new,
            'featured'             => $this->featured,
            'price'                => $this->price,
            'special_price'        => $this->special_price,
            'quantity'             => $this->quantity,
            'images'               => $this->images->pluck('path')->toArray(),
            'created_at'           => \Carbon\Carbon::parse($this->created_at)->format('Y/m/d H:i:s'),
            'updated_at'           => \Carbon\Carbon::parse($this->updated_at)->format('Y/m/d H:i:s'),
        ];
    }
}
