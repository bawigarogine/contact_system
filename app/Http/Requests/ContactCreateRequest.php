<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ContactCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (Auth::user()->usertype === 1) {
            return true;
        }else{
            return false;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'company' => 'required',
            'phone_num' => 'required',
            'email' => 'required|email',
        ];
    }

    public function messages():array{
        return [
            'name.required' => 'Please fill name',
            'company.required' => 'Please fill company',
            'phone_num.require' => 'Please fill phone',
            'email.required' => 'Please fill email',
            'email.email' => 'Invalid email format'
        ];
    }
}
