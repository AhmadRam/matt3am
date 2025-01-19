<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username'       => 'required|string|unique:users,username|max:255',
            'password'       => 'required|string|min:6',
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email|max:255',
            'status'         => 'boolean',
            'profile_image'  => 'nullable|image|max:2048',
            'restaurant_id'  => 'nullable|exists:restaurants,id',
        ];
    }
}
