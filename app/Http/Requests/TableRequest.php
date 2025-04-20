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
            'capacity' => 'required|integer|min:1',
            'qr_code' => 'required|string|unique:tables,qr_code',
            'status' => 'boolean',
            // 'section_id' => 'required|exists:sections,id',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
            'translations.*.description' => 'nullable|string',
            'translations.*.meta_title' => 'nullable|string|max:255',
            'translations.*.meta_keywords' => 'nullable|string|max:255',
            'translations.*.meta_description' => 'nullable|string',
        ];
    }
}
