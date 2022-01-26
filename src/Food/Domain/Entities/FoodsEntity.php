<?php
declare(strict_types=1);

namespace Src\Food\Domain\Entities;

final class FoodsEntity
{
    private array $foods;

    public function __construct()
    {
        $this->foods = [];
    }

    /**
     * función que agrega un Food y retorna la misma instancia
     * @param FoodEntity $food
     * @return $this
     */
    public function add(FoodEntity $food): FoodsEntity
    {
        array_push($this->foods,$food);
        return $this;
    }

    /**
     * retorna el tamaño de la colleción
     * @return int
     */
    public function size(): int{
        return count($this->foods);
    }

    /**
     * @return array
     */
    public function value(): array
    {
        return array_map(function (FoodEntity $food){
            return $food->getArrayValues();
        },$this->foods);
    }

}
