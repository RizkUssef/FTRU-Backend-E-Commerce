<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddProductRequest extends FormRequest
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
            "name"=>"required|string",
            "main_price"=>"required|numeric",
            "main_discount"=>"required|numeric",
            "main_size"=>[Rule::in('S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'ONE SIZE','NO SIZE','38-40','41-43','44-46')],
            "product_code"=>"required|string|max:6",
            "color"=>["regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/"],
            "quantity"=>"required|numeric",
            "image" => "required|image|mimes:jpeg,png,jpg,gif|max:2048", 
            "status" => ["required",Rule::in('show', 'hide')],
            // "delete_status" => ["required",Rule::in('Yes', 'No')],
        ];
    }
}
