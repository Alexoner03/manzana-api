<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserFoodRequest extends FormRequest
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
            "user_id" => "required|numeric|exists:users,id",
            "food_id" => "required|numeric|exists:foods,id",
        ];
    }

    public function messages()
    {
        return [
            "user_id.required" => "el campo user_id es requerido",
            "user_id.numeric" => "el campo user_id debe ser numerico",
            "user_id.exists" => "el usuario ingresado no existe",
            "food_id.required" => "el campo user_id es requerido",
            "food_id.numeric" => "el campo user_id debe ser numerico",
            "food_id.exists" => "el usuario ingresado no existe",
        ];
    }
}
