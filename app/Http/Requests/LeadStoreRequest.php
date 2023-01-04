<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadStoreRequest extends FormRequest
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
            'first_name' => ['required', 'max:255', 'string'],
            'last_name' => ['nullable', 'max:255', 'string'],
            'gender' => ['nullable', 'in:male,female,other'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'max:255', 'string'],
            'birthday' => ['nullable', 'date'],
            'notify_news' => ['required', 'boolean'],
            'notify_holiday' => ['required', 'boolean'],
            'notify_birthday' => ['required', 'boolean'],
            'notify_scratch_card' => ['required', 'boolean'],
            'notify_coupon' => ['required', 'boolean'],
            'branches' => ['array'],
        ];
    }
}
