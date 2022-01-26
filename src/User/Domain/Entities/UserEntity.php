<?php
declare(strict_types=1);

namespace Src\User\Domain\Entities;

use JetBrains\PhpStorm\Pure;
use Src\Food\Domain\Entities\FoodsEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserIsAdmin;
use Src\User\Domain\ValueObjects\UserLastName;
use Src\User\Domain\ValueObjects\UserName;
use Src\User\Domain\ValueObjects\UserPassword;

final class UserEntity
{
    private UserName $name;
    private UserLastName $last_name;
    private UserEmail $email;
    private UserPassword $password;
    private UserIsAdmin $is_admin;
    private UserId $id;
    private FoodsEntity $foods;

    /**
     * @param UserId $id
     * @param UserName $name
     * @param UserLastName $last_name
     * @param UserEmail $email
     * @param UserPassword $password
     */
    #[Pure] public function __construct(UserId $id, UserName $name, UserLastName $last_name, UserEmail $email, UserPassword $password)
    {
        $this->id           = $id;
        $this->name         = $name;
        $this->last_name    = $last_name;
        $this->email        = $email;
        $this->password     = $password;
        $this->is_admin     = new UserIsAdmin(false);
        $this->foods        = new FoodsEntity();
    }

    /**
     * @return UserName
     */
    public function getName(): UserName
    {
        return $this->name;
    }

    /**
     * @return UserLastName
     */
    public function getLastName(): UserLastName
    {
        return $this->last_name;
    }

    /**
     * @return UserEmail
     */
    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    /**
     * @return UserPassword
     */
    public function getPassword(): UserPassword
    {
        return $this->password;
    }

    /**
     * @return UserIsAdmin
     */
    public function getIsAdmin(): UserIsAdmin
    {
        return $this->is_admin;
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @param UserIsAdmin $is_admin
     * @return UserEntity
     */
    public function setIsAdmin(UserIsAdmin $is_admin): UserEntity
    {
        $this->is_admin = $is_admin;
        return $this;
    }

    /**
     * @return FoodsEntity
     */
    public function getFoods(): FoodsEntity
    {
        return $this->foods;
    }

    #[Pure] public static function create(UserId $id, UserName $name, UserLastName $last_name, UserEmail $email, UserPassword $password): UserEntity
    {
        return new self($id, $name, $last_name, $email, $password);
    }

    public function getArrayValues(): array
    {
        return [
            'id' => $this->id->value(),
            'name' => $this->name->value(),
            'lastName' => $this->last_name->value(),
            'email' => $this->email->value(),
            'isAdmin' => $this->is_admin->value(),
            'foods' => $this->foods->value()
        ];
    }
}
