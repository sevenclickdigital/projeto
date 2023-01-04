<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CouponUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tenant_id' => ['required', 'exists:tenants,id'],
            'active' => ['required', 'boolean'],
            'title' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'code' => ['required', 'max:255', 'string'],
            'coupon_type' => ['required', 'in:default,first_order'],
            'limit' => ['required', 'numeric'],
            'start_date' => ['required', 'date'],
            'expire_date' => ['required', 'date'],
            'min_purchase' => ['required', 'numeric'],
            'max_discount' => ['required', 'numeric'],
            'discount_type' => ['required', 'in:amount,percent'],
            'discount' => ['required', 'numeric'],
            'when_send' => ['required', 'date'],
            'branches' => ['array'],
        ];
    }
}
