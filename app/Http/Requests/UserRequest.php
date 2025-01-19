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
        $userId = $this->route('id');  // Get the user ID from the route

        return [
            'username'       => 'required|string|unique:users,username,' . $userId . '|max:255', // Exclude current user's username during update
            'password'       => 'required|string|min:6',
            'full_name'      => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $userId . '|max:255', // Exclude current user's email during update
            'status'         => 'boolean',
            'profile_image'  => 'nullable|image|max:2048',
            'restaurant_id'  => 'nullable|exists:restaurants,id',
        ];
    }
}
