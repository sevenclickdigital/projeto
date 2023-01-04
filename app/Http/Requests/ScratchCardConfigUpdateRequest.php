<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScratchCardConfigUpdateRequest extends FormRequest
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
            'Keyword' => ['required', 'max:255', 'string'],
            'when_send' => [
                'required',
                'in:no_send,one_week,two_weeks,one_month',
            ],
            'winner_photo_path' => ['image', 'max:1024', 'required'],
            'loser_photo_path' => ['image', 'max:1024', 'required'],
            'branches' => ['array'],
        ];
    }
}
