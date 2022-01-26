<?php

declare(strict_types=1);

namespace Src\User\Application\UseCases;


use Src\User\Application\Dtos\UserDto;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserLastName;
use Src\User\Domain\ValueObjects\UserName;
use Src\User\Domain\ValueObjects\UserPassword;

final class CreateUserUseCase
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Caso de uso para crear un usuario
     * @param string $name
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @return UserDto
     */
    public function __invoke(
        string $name,
        string $lastName,
        string $email,
        string $password,
    ): UserDto
    {
        $fakeId             = new UserId(1);
        $name               = new UserName($name);
        $lastName           = new UserLastName($lastName);
        $email              = new UserEmail($email);
        $password           = new UserPassword($password);

        //Creando instancia de Usuario del dominio
        $userCreated = UserEntity::create($fakeId, $name, $lastName, $email, $password);

        $userSaved = $this->repository->save($userCreated);

        return UserDto::mapFromUserEntity($userSaved);
    }
}
