<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Set to true to allow all users to make this request, otherwise add your authorization logic
    }

    public function rules()
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',         
        ];
    }
    public function messages()
    {
        return [
            'firstName' => 'First name required',
            'lastName' => 'Last Name required',
            'email' => 'Email required',         
        ];
    }
}
