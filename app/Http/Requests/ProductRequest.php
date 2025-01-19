<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'sku'               => 'nullable|string|unique:products,sku|max:255',
            'name'              => 'required|string|max:255',
            'url_key'           => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'short_description' => 'nullable|string',
            'meta_title'        => 'nullable|string|max:255',
            'meta_keywords'     => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string',
            'status'            => 'boolean',
            'new'               => 'boolean',
            'featured'          => 'boolean',
            'price'             => 'required|numeric|min:0',
            'special_price'     => 'nullable|numeric|min:0',
            'quantity'          => 'required|integer|min:0',
        ];
    }
}
