<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\Entities\FoodsEntity;
use Src\Food\Domain\ValueObjects\FoodDescription;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\Food\Domain\ValueObjects\FoodImagePath;
use Src\Food\Domain\ValueObjects\FoodName;

/**
 * App\Models\Food
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Food newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Food query()
 * @mixin Eloquent
 */
class Food extends Model
{
    use HasFactory;
    protected $table = "foods";
    protected $guarded = [];

    public static function mapFoodModelToEntity(Food $model): FoodEntity
    {
        return new FoodEntity(
            new FoodId($model->id),
            new FoodDescription($model->description),
            new FoodName($model->name),
            new FoodImagePath($model->imagePath),
        );
    }

    public static function mapFoodsModelToEntity(Collection $foods): FoodsEntity
    {
        $foodsEntities = new FoodsEntity;
        foreach ($foods as $food){
            $foodsEntities->add(
                Food::mapFoodModelToEntity($food)
            );
        }

        return $foodsEntities;
    }
}
