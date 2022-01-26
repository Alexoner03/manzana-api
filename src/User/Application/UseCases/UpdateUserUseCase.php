<?php
declare(strict_types=1);

namespace Src\User\Application\UseCases;

use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;

final class UpdateUserUseCase
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(UserEntity $entity): UserEntity
    {
        return $this->repository->update($entity);
    }
}
