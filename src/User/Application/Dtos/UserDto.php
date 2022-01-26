<?php
declare(strict_types = 1);

namespace Src\User\Application\Dtos;

use JetBrains\PhpStorm\Pure;
use Src\Food\Domain\Entities\FoodsEntity;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserIsAdmin;
use Src\User\Domain\ValueObjects\UserLastName;
use Src\User\Domain\ValueObjects\UserName;

final class UserDto
{
    private UserId  $id;
    private UserName $name;
    private UserLastName $last_name;
    private UserEmail $email;
    private UserIsAdmin $is_admin;
    private FoodsEntity $foods;

    /**
     * @param UserId $id
     * @param UserName $name
     * @param UserLastName $last_name
     * @param UserEmail $email
     * @param UserIsAdmin $is_admin
     * @param FoodsEntity $foodsEntity
     */
    public function __construct(UserId  $id, UserName $name, UserLastName $last_name, UserEmail $email, UserIsAdmin $is_admin, FoodsEntity $foodsEntity)
    {
        $this->id = $id;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->is_admin = $is_admin;
        $this->foods = $foodsEntity;
    }

    /**
     * @return UserName
     */
    public function getName(): UserName
    {
        return $this->name;
    }

    /**
     * @param UserName $name
     */
    public function setName(UserName $name): void
    {
        $this->name = $name;
    }

    /**
     * @return UserLastName
     */
    public function getLastName(): UserLastName
    {
        return $this->last_name;
    }

    /**
     * @param UserLastName $last_name
     */
    public function setLastName(UserLastName $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return UserEmail
     */
    public function getEmail(): UserEmail
    {
        return $this->email;
    }

    /**
     * @param UserEmail $email
     */
    public function setEmail(UserEmail $email): void
    {
        $this->email = $email;
    }

    /**
     * @return UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @param UserId $id
     */
    public function setId(UserId $id): void
    {
        $this->id = $id;
    }

    /**
     * @return UserIsAdmin
     */
    public function getIsAdmin(): UserIsAdmin
    {
        return $this->is_admin;
    }

    /**
     * @param UserIsAdmin $is_admin
     */
    public function setIsAdmin(UserIsAdmin $is_admin): void
    {
        $this->is_admin = $is_admin;
    }

    /**
     * @return FoodsEntity
     */
    public function getFoods(): FoodsEntity
    {
        return $this->foods;
    }

    /**
     * @param UserEntity $entity
     * @return UserDto
     */
    #[Pure] public static function mapFromUserEntity(UserEntity $entity): UserDto
    {
        return new self(
            $entity->getId(),
            $entity->getName(),
            $entity->getLastName(),
            $entity->getEmail(),
            $entity->getIsAdmin(),
            $entity->getFoods()
        );
    }

    public function getArrayValues(): array
    {
        return [
            "id" => $this->id->value(),
            'name' => $this->name->value(),
            'lastName' => $this->last_name->value(),
            'email' => $this->email->value(),
            'isAdmin' => $this->is_admin->value(),
            'foods' => $this->foods->value()
        ];
    }

}
