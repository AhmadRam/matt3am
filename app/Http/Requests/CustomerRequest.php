<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'gender'            => 'nullable|string|max:50',
            'date_of_birth'     => 'nullable|date',
            'email'             => 'nullable|email|unique:customers,email|max:255',
            'phone_code'        => 'nullable|string|max:10',
            'phone'             => 'nullable|string|max:20',
            'image'             => 'nullable|image|max:2048',
            'password'          => 'nullable|string|min:8',
            'is_verified'       => 'boolean',
            'notes'             => 'nullable|string',
            'customer_group_id' => 'nullable|exists:customer_groups,id',
        ];
    }
}
