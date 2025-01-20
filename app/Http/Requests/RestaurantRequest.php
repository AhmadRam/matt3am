<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                     => 'required|string|max:255',
            'description'              => 'nullable|string',
            'address'                  => 'nullable|string',
            'phone_code'               => 'nullable|string|max:10',
            'phone'                    => 'nullable|string|max:20',
            'logo'                     => 'nullable|image|max:2048',
            'status'                   => 'boolean',
            'subscription_start_date'  => 'required|date',
            'subscription_end_date'    => 'required|date|after:subscription_start_date',
            'user_id'                  => 'required|exists:users,id',
            'currency_id'              => 'required|exists:currencies,id',
            'meta_title'               => 'nullable|string|max:255',
            'meta_keywords'            => 'nullable|string|max:255',
            'meta_description'         => 'nullable|string',
        ];
    }
}
