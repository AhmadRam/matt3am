<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'             => 'required|string|max:255',
            'capacity'         => 'required|integer|min:1',
            'qr_code'          => 'required|string|max:255',
            'status'           => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_keywords'    => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'section_id'       => 'required|exists:sections,id',
        ];
    }
}
