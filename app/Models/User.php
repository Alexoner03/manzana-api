<?php

namespace App\Models;

use Eloquent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as AuthenticatableClass;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Src\Food\Domain\Entities\FoodsEntity;
use Src\User\Application\Dtos\UserDto;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserIsAdmin;
use Src\User\Domain\ValueObjects\UserLastName;
use Src\User\Domain\ValueObjects\UserName;
use Src\User\Domain\ValueObjects\UserPassword;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\User
 *
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @mixin Eloquent
 */
class User extends AuthenticatableClass implements JWTSubject
{
    use HasFactory;

    protected $guarded = ["is_admin"];

    protected $casts = [
        "isAdmin" => "boolean"
    ];

    /**
     * this function return foods from user
     * @return BelongsToMany
     */
    public function foods(): BelongsToMany
    {
        return $this->belongsToMany(Food::class,"user_food");
    }

    /**
     * @param User|Model $userModel
     * @return UserEntity
     */
    public static function UserModelToEntity(User|Model $userModel): UserEntity
    {
        $user = new UserEntity(
            new UserId($userModel->id),
            new UserName($userModel->name),
            new UserLastName($userModel->lastName),
            new UserEmail($userModel->email),
            new UserPassword($userModel->password),
        );

        if($userModel->isAdmin)
        {
            $user->setIsAdmin(new UserIsAdmin(true));
        }

        foreach ($userModel->foods as $food){
            $user->getFoods()->add(
                Food::mapFoodModelToEntity($food)
            );
        }

        return $user;
    }

    /**
     * @param User|Model $userModel
     * @return UserDto
     */
    public static function UserModelToDto(User|Authenticatable $userModel): UserDto
    {
        $user = new UserDto(
            new UserId($userModel->id),
            new UserName($userModel->name),
            new UserLastName($userModel->lastName),
            new UserEmail($userModel->email),
            new UserIsAdmin($userModel->isAdmin),
            new FoodsEntity()
        );

        foreach ($userModel->foods as $food){
            $user->getFoods()->add(
                Food::mapFoodModelToEntity($food)
            );
        }

        return $user;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
