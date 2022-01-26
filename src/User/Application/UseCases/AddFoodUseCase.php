<?php
declare(strict_types=1);

namespace Src\User\Application\UseCases;

use Src\Food\Domain\ValueObjects\FoodId;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserId;

final class AddFoodUseCase
{
    private UserRepositoryContract $repository;

    public function __construct(UserRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(int $id, int $foodId): UserEntity
    {
        $UserId = new UserId($id);
        $FoodId = new FoodId($foodId);

        return $this->repository->addFood($UserId,$FoodId);
    }
}
