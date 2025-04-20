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
            // 'address'                  => 'nullable|string',
            // 'phone_code'               => 'nullable|string|max:10',
            // 'phone'                    => 'nullable|string|max:20',
            // 'status'                   => 'boolean',
            // 'subscription_start_date'  => 'required|date',
            // 'subscription_end_date'    => 'required|date|after:subscription_start_date',
            // 'user_id'                  => 'required|exists:users,id',
            // 'currency_id'              => 'required|exists:currencies,id',
            // 'translations' => 'required|array',
            // 'translations.*.name' => 'required|string|max:255',
            // 'translations.*.description' => 'nullable|string',
            // 'translations.*.logo' => 'nullable|max:2048',
            // 'translations.*.meta_title' => 'nullable|string|max:255',
            // 'translations.*.meta_keywords' => 'nullable|string|max:255',
            // 'translations.*.meta_description' => 'nullable|string',
        ];
    }
}
