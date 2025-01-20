<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $categoryId = $this->route('id');

        return [
            'name'             => 'required|string|max:255',
            'position'         => 'integer|min:0',
            'status'           => 'boolean',
            'image'            => 'nullable|image|max:2048',
            'slug'             => 'required|string|unique:categories,slug,' . $categoryId . '|max:255',
            'url_key'          => 'nullable|string|max:255',
            'description'      => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:255',
            'restaurant_id'    => 'required|exists:restaurants,id',
            'currency_id'      => 'required|exists:currencies,id',
        ];
    }
}
