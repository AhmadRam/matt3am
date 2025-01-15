<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
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
            'capacity'             => $this->capacity,
            'qr_code'             => $this->qr_code,
            'status'               => $this->status,
            'meta_title'           => $this->meta_title,
            'meta_keywords'        => $this->meta_keywords,
            'meta_description'     => $this->meta_description,
            'section_id'           => $this->section_id,
            'created_at'           => \Carbon\Carbon::parse($this->created_at)->format('Y/m/d H:i:s'),
            'updated_at'           => \Carbon\Carbon::parse($this->updated_at)->format('Y/m/d H:i:s'),
        ];
    }
}
