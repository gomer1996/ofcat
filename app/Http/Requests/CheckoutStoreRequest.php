<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CheckoutStoreRequest extends FormRequest
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
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'address.required' => 'Необходимо заполнить поле',
            'company.required_if' => 'Необходимо заполнить поле',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'delivery' => [
                'required',
                Rule::in(['delivery', 'pickup']),
            ],
            'address' => 'required_if:delivery,delivery',
            'company' => 'required_if:user_type,company',
            'user_type' => [
                'required',
                Rule::in(['company', 'person']),
            ],
        ];
    }
}
