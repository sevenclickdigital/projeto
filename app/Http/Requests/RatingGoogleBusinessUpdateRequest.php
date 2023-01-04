<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingGoogleBusinessUpdateRequest extends FormRequest
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
            'text' => ['nullable', 'max:255', 'string'],
            'stars' => [
                'nullable',
                'in:one_star,two_stars,three_stars,four_stars,five_stars',
            ],
            'branches' => ['array'],
        ];
    }
}
