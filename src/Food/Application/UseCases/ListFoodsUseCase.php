<?php
declare(strict_types=1);

namespace Src\Food\Application\UseCases;

use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Domain\Entities\FoodsEntity;

final class ListFoodsUseCase
{
    private FoodRepositoryContract $repository;

    public function __construct(FoodRepositoryContract $repository)
    {
        $this->repository  = $repository;
    }

    public function __invoke():FoodsEntity
    {
        return $this->repository->list();
    }
}
