<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'type' => ['required', 'in:catalog_online,catalog_pdf'],
            'category_product_id' => [
                'required',
                'exists:category_products,id',
            ],
            'product_photo_path' => ['image', 'max:1024', 'nullable'],
            'name' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'max:255', 'string'],
            ' button_text' => ['nullable', 'max:255', 'string'],
            ' button_path' => ['nullable', 'max:255', 'string'],
            'branches' => ['array'],
        ];
    }
}
