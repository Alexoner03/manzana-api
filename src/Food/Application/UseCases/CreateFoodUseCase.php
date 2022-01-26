<?php
declare(strict_types=1);

namespace Src\Food\Application\UseCases;

use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\ValueObjects\FoodDescription;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\Food\Domain\ValueObjects\FoodImagePath;
use Src\Food\Domain\ValueObjects\FoodName;

final class CreateFoodUseCase
{
    private FoodRepositoryContract $repository;

    public function __construct(FoodRepositoryContract $repository)
    {
        $this->repository  = $repository;
    }

    public function __invoke(
        string $name,
        string $description,
        string $imagePath
    ): ?FoodEntity
    {
        $foodName           =   new FoodName($name);
        $foodDescription    =   new FoodDescription($name);
        $foodImagePath      =   new FoodImagePath($name);

        $food = new FoodEntity(
            new FoodId(1),
            $foodDescription,
            $foodName,
            $foodImagePath
        );

        return $this->repository->save($food);
    }
}
