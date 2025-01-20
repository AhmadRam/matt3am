<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'        => 'required|string|max:255',
            'title'       => 'required|string|max:255',
            'rating'      => 'required|integer|between:1,5',
            'comment'     => 'nullable|string',
            'status'      => 'required|string|max:50',
            'customer_id' => 'nullable|exists:customers,id',
            'product_id'  => 'required|exists:products,id',
        ];
    }
}
