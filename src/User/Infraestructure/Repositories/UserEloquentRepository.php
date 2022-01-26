<?php
declare(strict_types=1);

namespace Src\User\Infraestructure\Repositories;

use App\Models\Food;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use InvalidArgumentException;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserIsAdmin;
use Src\User\Domain\ValueObjects\UserLastName;
use Src\User\Domain\ValueObjects\UserName;
use Src\User\Domain\ValueObjects\UserPassword;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

final class UserEloquentRepository implements UserRepositoryContract
{
    private User $model;

    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * @param UserEntity $user
     * @return UserEntity
     */
    public function save(UserEntity $user): UserEntity
    {
        $newUser = $this->model;

        $data = [
            'name'              => $user->getName()->value(),
            'lastName'          => $user->getLastName()->value(),
            'email'             => $user->getEmail()->value(),
            'password'          => Hash::make($user->getPassword()->value()),
        ];

        $userModel = $newUser->create($data);

        return User::UserModelToEntity($userModel);

    }

    /**
     * @param UserId $id
     * @return UserEntity
     */
    public function find(UserId $id): UserEntity
    {
        $userModel =  User::findOrFail($id->value());
        return User::UserModelToEntity($userModel);
    }

    /**
     * @param UserEmail $email
     * @param UserPassword $password
     * @return UserEntity
     */
    public function findByEmailAndPassword(UserEmail $email, UserPassword $password): UserEntity
    {
        $userModel =  User::where('email',$email->value())->first();

        if($userModel === null)
        {
            throw new UnauthorizedException("Invalid Credentials");
        }

        $checkPassword = Hash::check($password->value(), $userModel->password);

        if(!$checkPassword)
        {
            throw new UnauthorizedException("Invalid Credentials");
        }

        return User::UserModelToEntity($userModel);
    }

    /**
     * @param UserId $id
     * @return UserEntity
     */
    public function toAdmin(UserId $id): UserEntity
    {
        $user = User::findOrFail($id->value());
        $user->isAdmin = true;
        $user->save();
        return User::UserModelToEntity($user);
    }

    /**
     * @param UserEntity $entity
     * @return UserEntity
     * @throws Throwable
     */
    public function update(UserEntity $entity): UserEntity
    {
        $user = User::findOrFail($entity->getId()->value())->with('foods')->first();
        $user->name = $entity->getName()->value();
        $user->lastName = $entity->getLastName()->value();
        $user->email = $entity->getEmail()->value();
        $user->save();
        $user->refresh();
        return User::UserModelToEntity($user);
    }

    /**
     * @param UserId $id
     * @param FoodId $foodId
     * @return UserEntity
     */
    public function addFood(UserId $id, FoodId $foodId): UserEntity
    {
        $user = User::findOrFail($id->value())->with('foods')->first();
        $exists = $user->foods->where("id",$foodId->value())->first();
        if($exists !== null)
        {
            throw new UnprocessableEntityHttpException("la comida ya existe en la lista del usuario");
        }

        $food = Food::findOrFail($foodId->value());
        $user->foods()->attach($food->id);
        $user->save();
        $user->load("foods");
        return User::UserModelToEntity($user);
    }

    /**
     * @param UserId $id
     * @param FoodId $foodId
     * @return UserEntity
     */
    public function removeFood(UserId $id, FoodId $foodId): UserEntity
    {
        $user = User::findOrFail($id->value());
        $food = Food::findOrFail($foodId->value());
        $user->foods()->detach($food->id);
        $user->save();
        $user->load("foods");
        return User::UserModelToEntity($user);
    }
}
