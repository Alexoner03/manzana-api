<?php

namespace App\Http\Requests;

use App\Models\Food;
use Illuminate\Foundation\Http\FormRequest;
use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\ValueObjects\FoodDescription;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\Food\Domain\ValueObjects\FoodImagePath;
use Src\Food\Domain\ValueObjects\FoodName;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserLastName;
use Src\User\Domain\ValueObjects\UserName;
use Src\User\Domain\ValueObjects\UserPassword;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->input("id") === auth()->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => "required|numeric|exists:users,id",
            "name" => "required|string|max:255",
            "lastName" => "required|string|max:255",
        ];
    }

    public function messages()
    {
        return [
            "id.required" => "El campo id es requerido",
            "id.numeric" => "El campo id debe ser numerico",
            "id.exists" => "El usuario no existe",
            "name.required" => "el campo nombre es requerido",
            "name.string" => "el campo nombre debe ser un texto",
            "name.max" => "el campo nombre debe ser de 255 letras como maximo",
            "lastName.required" => "el campo nombre es requerido",
            "lastName.string" => "el campo nombre debe ser un texto",
            "lastName.max" => "el campo nombre debe ser de 255 letras como maximo",
        ];
    }

    public static function validateFieldsToEntity(array $fields): UserEntity
    {
        return new UserEntity(
            new UserId($fields["id"]),
            new UserName($fields["name"]),
            new UserLastName($fields["lastName"]),
            new UserEmail($fields["fakeEmail@test.com"]), //TODO: create an UpdateDTO
            new UserPassword("empty"),
        );
    }
}
