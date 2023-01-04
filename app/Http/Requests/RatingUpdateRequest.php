<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingUpdateRequest extends FormRequest
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
            'award_photo_path' => ['image', 'max:1024', 'nullable'],
            'subject' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
            'branches' => ['array'],
        ];
    }
}
