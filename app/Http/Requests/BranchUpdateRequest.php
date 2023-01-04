<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchUpdateRequest extends FormRequest
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
            'branch_logo_path' => ['image', 'max:1024', 'nullable'],
            'branch_cover_path' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:255', 'string'],
            'currency' => ['nullable', 'max:3', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'slug' => ['nullable', 'max:255', 'string'],
            'phone' => ['nullable', 'max:255', 'string'],
            'cell' => ['nullable', 'max:255', 'string'],
            'email' => ['nullable', 'email'],
            'place_id' => ['nullable', 'numeric'],
            'coordinates' => ['nullable', 'max:255', 'string'],
            'address' => ['nullable', 'max:255', 'string'],
            'city' => ['nullable', 'max:255', 'string'],
            'state' => ['nullable', 'max:255', 'string'],
            'zip_code' => ['nullable', 'max:255', 'string'],
            'country' => ['nullable', 'max:255', 'string'],
            'tenant_id' => ['required', 'exists:tenants,id'],
        ];
    }
}
