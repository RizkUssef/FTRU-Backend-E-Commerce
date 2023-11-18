<?php

namespace App\Http\Requests;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $country = Country::pluck("id")->all();
        return [
            "name"=>"required|string",
            "email"=>"required|email|unique:users,email",
            "phone"=>"required|numeric|min:10",
            "gender"=>["required",Rule::in(["male","female"])],
            "country_id"=>["required",Rule::in($country)],
            "address"=>"nullable|string",
            "password"=>"required|confirmed|min:10",
        ];
    }

    // public function messages()
    // {
    //     return [
    //         'name.required' => "The name is required.",
    //         'email.required' => 'The email is required.',
    //         'email.unique' => 'You used this email before',
    //         'password.required' => 'The password is required.',
    //         'password.confirmed' => 'Have you forgotten your password already ???!!',
    //         'password.min' => 'The password must greater than 10 char',
    //     ];
    // }
}
