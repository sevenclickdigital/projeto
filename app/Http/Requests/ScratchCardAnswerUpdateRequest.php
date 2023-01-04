<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScratchCardAnswerUpdateRequest extends FormRequest
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
            'sending_order' => ['nullable', 'numeric'],
            'type' => ['nullable', 'in:true,false'],
            'template_type' => ['nullable', 'in:true,false'],
            'elements_title' => ['nullable', 'max:255', 'string'],
            'elements_image_url' => ['nullable', 'max:255', 'string'],
            'elements_subtitle' => ['nullable', 'max:255', 'string'],
            'action_type' => ['nullable', 'max:255', 'string'],
            'action_url' => ['nullable', 'max:255', 'string'],
            'action_messenger_extensions' => ['nullable', 'in:true,false'],
            'action_webview_height_ratio' => [
                'nullable',
                'in:compact,tall,full',
            ],
            'buttons_type' => ['nullable', 'max:255', 'string'],
            'buttons_url' => ['nullable', 'max:255', 'string'],
            'buttons_title' => ['nullable', 'max:255', 'string'],
        ];
    }
}
