<?php

namespace Src\User\Application\UseCases;

use Src\User\Application\Dtos\UserDto;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserPassword;

final class LoginUseCase
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Caso de uso para iniciar sesion
     * @param string $email
     * @param string $password
     * @return UserDto|null
     */
    public function __invoke(
        string $email,
        string $password
    ): ?UserDto
    {
        $userEmail = new UserEmail($email);
        $userPassword = new UserPassword($password);

        $user = $this->repository->findByEmailAndPassword($userEmail, $userPassword);

        return UserDto::mapFromUserEntity($user);
    }
}
