<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialLeadUpdateRequest extends FormRequest
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
            'active' => ['required', 'boolean'],
            'profile_photo_path' => ['image', 'max:1024', 'nullable'],
            'social_id' => ['nullable', 'max:255', 'string'],
            'social_key' => ['nullable', 'max:255', 'string'],
            'tenant_id' => ['required', 'exists:tenants,id'],
            'social_type' => ['required', 'in:instagram,facebook,whatsapp'],
        ];
    }
}
