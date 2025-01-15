<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name'              => $this->name,
            'position'          => $this->position,
            'status'            => $this->status,
            'image'             => $this->image,
            'slug'              => $this->slug,
            'url_key'           => $this->url_key,
            'description'       => $this->description,
            'meta_title'        => $this->meta_title,
            'meta_description'  => $this->meta_description,
            'meta_keywords'     => $this->meta_keywords,
            'restaurant_id'     => $this->restaurant_id,
            'currency_id'       => $this->currency_id,
            'created_at'        => \Carbon\Carbon::parse($this->created_at)->format('Y/m/d H:i:s'),
            'updated_at'        => \Carbon\Carbon::parse($this->updated_at)->format('Y/m/d H:i:s'),
            'parent'            => $this->parent ? new self($this->parent) : null, // Nested set parent category (if exists)
            'children'          => CategoryResource::collection($this->children), // Nested set children categories
        ];
    }
}
