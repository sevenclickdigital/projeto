<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScratchCardUpdateRequest extends FormRequest
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
            'published' => ['required', 'in:published,draft,archived'],
            'award_photo_path' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'Keyword' => ['nullable', 'max:255', 'string'],
            'chances_of_winning' => ['required', 'numeric'],
            ' play_number' => ['required', 'numeric'],
            'show_day' => ['required', 'max:255', 'string'],
            'prize_availability' => ['required', 'in:always,date'],
            'prize_date_end' => ['nullable', 'date'],
            'branches' => ['array'],
        ];
    }
}
