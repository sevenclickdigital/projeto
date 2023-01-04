<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QrbilderStoreRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'max:255', 'string'],
            'bilder_photo_path' => ['image', 'max:1024', 'nullable'],
            'branches' => ['array'],
        ];
    }
}
