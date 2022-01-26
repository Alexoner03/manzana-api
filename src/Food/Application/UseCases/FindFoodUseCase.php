<?php
declare(strict_types=1);

namespace Src\Food\Application\UseCases;

use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\ValueObjects\FoodId;

final class FindFoodUseCase
{
    private FoodRepositoryContract $repository;

    public function __construct(FoodRepositoryContract $repository)
    {
        $this->repository  = $repository;
    }

    public function __invoke(
        int $id
    ): ?FoodEntity
    {
        $foodId = new FoodId($id);
        return $this->repository->find($foodId);
    }
}
