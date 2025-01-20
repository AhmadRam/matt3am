<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'            => 'required|string|max:255|unique:currencies,name',
            'code'            => 'required|string|max:10|unique:currencies,code',
            'symbol'          => 'required|string|max:10',
            'conversion_rate' => 'required|numeric|min:0',
            'status'          => 'boolean',
        ];
    }
}
