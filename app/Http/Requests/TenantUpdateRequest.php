<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenantUpdateRequest extends FormRequest
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
            'max_lead' => ['nullable', 'numeric'],
            'max_branch' => ['nullable', 'numeric'],
            'facebook_page_id' => ['nullable', 'max:255', 'string'],
            'facebook_access_token' => ['nullable', 'max:255', 'string'],
            'instagram_page_id' => ['nullable', 'max:255', 'string'],
            'instagram_access_token' => ['nullable', 'max:255', 'string'],
            'color_primary' => ['nullable', 'max:9', 'string'],
            'color_secondary' => ['nullable', 'max:9', 'string'],
            'custom_font' => ['nullable', 'max:255', 'string'],
            'participation_terms' => ['nullable', 'max:255', 'string'],
            'privacy' => ['nullable', 'max:255', 'string'],
            'terms_of_use' => ['nullable', 'max:255', 'string'],
        ];
    }
}
