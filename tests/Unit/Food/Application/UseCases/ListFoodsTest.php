<?php
declare(strict_types=1);

namespace Food\Application\UseCases;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Food\Application\UseCases\ListFoodsUseCase;
use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Domain\Entities\FoodsEntity;

class ListFoodsTest extends TestCase
{
    /**
     * @test
     */
    public function should_return_food_list()
    {
        //llamada a metodo de repositorio
        $foodRepositoryMock = Mockery::mock(FoodRepositoryContract::class);
        $foodRepositoryMock->shouldReceive('list')->once();

        //ejecutamos el useCase
        $useCase = new ListFoodsUseCase($foodRepositoryMock);
        $foodsResult = $useCase();

        //instancia ok
        $this->assertInstanceOf(FoodsEntity::class,$foodsResult);
        Mockery::getContainer()->mockery_close();
    }
}
