<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'company_name' => Rule::requiredIf(auth()->user()->type === 'company'),
            'name' => 'required',
            'phone' => 'required',
            'email' => ['required', Rule::unique('users')->ignore(auth()->user()->id)],
        ];
    }
}
