<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerGroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $customerId = $this->route('id');

        return [
            'code' => 'required|string|max:255|unique:customer_groups,code,' . $customerId,
            'name' => 'required|string|max:255',
            'is_user_defined' => 'sometimes|boolean',
        ];
    }
}
