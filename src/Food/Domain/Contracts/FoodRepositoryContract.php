<?php
declare(strict_types=1);

namespace Src\Food\Domain\Contracts;

use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\Entities\FoodsEntity;
use Src\Food\Domain\ValueObjects\FoodId;

interface FoodRepositoryContract
{
    /**
     * @param FoodEntity $food
     * @return FoodEntity
     */
    public function save(FoodEntity $food): FoodEntity;

    /**
     * @param FoodId $id
     * @return FoodEntity
     */
    public function find(FoodId $id): FoodEntity;

    /**
     * @param FoodEntity $food
     * @return FoodEntity
     */
    public function update(FoodEntity $food): FoodEntity;

    /**
     * @return FoodsEntity
     */
    public function list(): FoodsEntity;
}
