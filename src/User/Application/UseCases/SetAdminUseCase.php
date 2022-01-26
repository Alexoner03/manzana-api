<?php

namespace Src\User\Application\UseCases;

use Src\User\Application\Dtos\UserDto;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\ValueObjects\UserId;

final class SetAdminUseCase
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int $id
     * @return UserDto
     */
    public function __invoke(
        int $id
    ): UserDto
    {
        $userid = new UserId($id);
        $user = $this->repository->toAdmin($userid);
        return UserDto::mapFromUserEntity($user);
    }
}
