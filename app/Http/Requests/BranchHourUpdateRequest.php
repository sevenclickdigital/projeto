<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BranchHourUpdateRequest extends FormRequest
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
            'day' => [
                'required',
                'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            ],
            'hour_start' => ['nullable', 'date_format:H:i:s'],
            'tenant_id' => ['required', 'exists:tenants,id'],
            'hour_end' => ['nullable', 'date_format:H:i:s'],
            'branch_id' => ['required', 'exists:branches,id'],
        ];
    }
}
