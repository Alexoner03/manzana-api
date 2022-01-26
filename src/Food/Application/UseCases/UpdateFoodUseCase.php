<?php
declare(strict_types=1);

namespace Src\Food\Application\UseCases;

use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Domain\Entities\FoodEntity;

final class UpdateFoodUseCase
{
    private FoodRepositoryContract $repository;

    public function __construct(FoodRepositoryContract $repository)
    {
        $this->repository  = $repository;
    }

    public function __invoke(FoodEntity $entity): ?FoodEntity
    {
        return $this->repository->update($entity);
    }
}
