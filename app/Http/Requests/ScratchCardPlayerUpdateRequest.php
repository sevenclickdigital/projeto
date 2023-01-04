<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScratchCardPlayerUpdateRequest extends FormRequest
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
            'scratch_card_id' => ['required', 'exists:scratch_cards,id'],
            'lead_id' => ['required', 'exists:leads,id'],
            'winner' => ['required', 'boolean'],
        ];
    }
}
