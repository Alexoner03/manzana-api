<?php
declare(strict_types = 1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserLastName;
use Src\User\Domain\ValueObjects\UserName;
use Src\User\Domain\ValueObjects\UserPassword;

class CreateUserRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' =>   'required|string|max:255|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "El nombre es requerido",
            "name.max" => "El nombre deber maximo de 255 letras",
            "name.string" => "El nombre debe ser un texto",
            "lastName.required" => "El apellido es requerido",
            "lastName.max" => "El apellido deber maximo de 255 letras",
            "lastName.string" => "El apellido debe ser un texto",
            "email.email" => "Debe ingresar el formato correcto para email",
            "email.required" => "El email es requerido",
            "email.max" => "El email deber maximo de 255 letras",
            "email.unique" => "El email ingresado ya está registrado",
        ];
    }
}
