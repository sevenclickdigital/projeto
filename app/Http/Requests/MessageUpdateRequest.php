<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageUpdateRequest extends FormRequest
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
            'text' => ['required', 'max:255', 'string'],
            'read' => ['required', 'boolean'],
            'message_key' => ['required', 'max:255', 'string'],
            'sender' => ['required', 'in:user,company'],
            'sender_id' => ['nullable', 'max:255'],
            'receiver_id' => ['nullable', 'max:255'],
            'tenant_id' => ['required', 'exists:tenants,id'],
        ];
    }
}
