<?php
declare(strict_types=1);

namespace Src\Food\Infraestructure\Repositories;

use App\Models\Food;
use Illuminate\Database\Eloquent\Collection;
use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\Entities\FoodsEntity;
use Src\Food\Domain\ValueObjects\FoodDescription;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\Food\Domain\ValueObjects\FoodImagePath;
use Src\Food\Domain\ValueObjects\FoodName;

final class FoodEloquentRepository implements FoodRepositoryContract
{

    public function save(FoodEntity $food): FoodEntity
    {
        $food = Food::create([
            "description" => $food->getDescription()->value(),
            "name" => $food->getName()->value(),
            "imagePath" => $food->getImagePath()->value(),
        ]);

        return Food::mapFoodModelToEntity($food);
    }

    public function find(FoodId $id): FoodEntity
    {
        $food = Food::findOrFail($id->value());
        return Food::mapFoodModelToEntity($food);
    }

    public function update(FoodEntity $food): FoodEntity
    {
        $foodToUpdate = Food::findOrFail($food->getId()->value());
        $foodToUpdate->name = $food->getName()->value();
        $foodToUpdate->description = $food->getDescription()->value();
        $foodToUpdate->imagePath = $food->getImagePath()->value();

        $foodToUpdate->save();

        return $food;
    }

    public function list(): FoodsEntity
    {
       $foods = Food::all();
       return Food::mapFoodsModelToEntity($foods);
    }
}
