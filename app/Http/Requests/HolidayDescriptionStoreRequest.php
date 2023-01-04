<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HolidayDescriptionStoreRequest extends FormRequest
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
            'holiday_id' => ['required', 'exists:holidays,id'],
            'active' => ['required', 'boolean'],
            'when_send' => [
                'required',
                'in:one_day,two_days,three_days,four_days,five_days,one_week,two_weeks,one_month,in_day',
            ],
            'time' => ['required', 'date_format:H:i:s'],
            'subject' => ['required', 'max:255', 'string'],
            'content' => ['required', 'max:255', 'string'],
            'branches' => ['array'],
        ];
    }
}
