<?php

namespace App\Http\Requests;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AllOrderRequest extends FormRequest
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
            "country_id"=>["required",Rule::in($country)],
            "state"=>"required|string",
            "city"=>"required|string",
            "street_number"=>"required|string",
            "address_line1"=>"required|string",
            "address_line2"=>"required|string",
            "unit_number"=>"required|string",
            "email"=>"required|email",
            "phone"=>"required|numeric|min:10",
        ];
    }
}
