<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserFoodRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Src\User\Application\Dtos\UserDto;
use Src\User\Application\UseCases\AddFoodUseCase;
use Src\User\Application\UseCases\CreateUserUseCase;
use Src\User\Application\UseCases\LoginUseCase;
use Src\User\Application\UseCases\RemoveFoodUseCase;
use Src\User\Application\UseCases\UpdateUserUseCase;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    private UserRepositoryContract $repository;

    /**
     * @param UserRepositoryContract $repository
     */
    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateUserRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $useCase = new CreateUserUseCase($this->repository);

        $userDto = $useCase(
            $fields['name'],
            $fields['lastName'],
            $fields['email'],
            $fields['password'],
        );

        return response()->json($userDto->getArrayValues(), 201);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $useCase = new LoginUseCase($this->repository);

        $userDto = $useCase(
            $fields["email"],
            $fields["password"],
        );

        try {
            //el useCase valida si el email y la contraseña son correctas
            $token = auth()->attempt($fields);

        } catch (JWTException $e) {

            return response()->json(['error' => 'no se pudo crear el token'], 500);

        }

        return response()->json([
            "user" => $userDto->getArrayValues(),
            "token" => $token
        ]);
    }

    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $useCase = new UpdateUserUseCase($this->repository);
        $userEntity = $useCase(UpdateUserRequest::validateFieldsToEntity($fields));
        return response()->json($userEntity->getArrayValues());
    }

    /**
     * @param UserFoodRequest $request
     * @return JsonResponse
     */
    public function addFood(UserFoodRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $useCase = new AddFoodUseCase($this->repository);
        $user = $useCase(
            $fields["user_id"],
            $fields["food_id"],
        );

        return response()->json($user->getArrayValues());
    }

    /**
     * @param UserFoodRequest $request
     * @return JsonResponse
     */
    public function removeFood(UserFoodRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $useCase = new RemoveFoodUseCase($this->repository);
        $user = $useCase(
            $fields["user_id"],
            $fields["food_id"],
        );

        return response()->json($user->getArrayValues());
    }

    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        $user = auth()->user();
        $userEntity = User::UserModelToDto($user);
        return response()->json($userEntity->getArrayValues());
    }
}
