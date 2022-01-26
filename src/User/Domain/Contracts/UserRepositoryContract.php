<?php

namespace Src\User\Domain\Contracts;

use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserPassword;

interface UserRepositoryContract
{
    /**
     * @param UserEntity $user
     * @return UserEntity
     */
    public function save(UserEntity $user): UserEntity;

    /**
     * @param UserId $id
     * @return UserEntity
     */
    public function find(UserId $id): UserEntity;

    /**
     * @param UserEmail $email
     * @param UserPassword $password
     * @return UserEntity
     */
    public function findByEmailAndPassword(UserEmail $email, UserPassword $password): UserEntity;

    /**
     * función que actualiza un usuario volviendolo administrador
     * @param UserId $id
     * @return UserEntity
     */
    public function toAdmin(UserId $id): UserEntity;

    /**
     * @param UserEntity $entity
     * @return UserEntity
     */
    public function update(UserEntity $entity): UserEntity;

    /**
     * @param UserId $id
     * @param FoodId $foodId
     * @return UserEntity
     */
    public function addFood(UserId $id,FoodId $foodId): UserEntity;

    /**
     * @param UserId $id
     * @param FoodId $foodId
     * @return UserEntity
     */
    public function removeFood(UserId $id,FoodId $foodId): UserEntity;
}
