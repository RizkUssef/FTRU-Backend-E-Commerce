<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AddProductColorSizeRequest extends FormRequest
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
        return [
            "product_code"=>"required|string|max:6",
            "size"=>[Rule::in('S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'ONE SIZE','NO SIZE','38-40','41-43','44-46')],
            "color"=>["regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/"],
            "quantity"=>"required|numeric",
            "image" => "required|image|mimes:jpeg,png,jpg,gif|max:2048",
        ];
    }
}
