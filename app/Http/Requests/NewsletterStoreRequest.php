<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsletterStoreRequest extends FormRequest
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
            'sent' => ['required', 'boolean'],
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i:s'],
            'subject' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
            'branches' => ['array'],
        ];
    }
}
