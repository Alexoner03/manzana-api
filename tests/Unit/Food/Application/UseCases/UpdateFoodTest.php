<?php
declare(strict_types=1);

namespace Food\Application\UseCases;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Food\Application\UseCases\UpdateFoodUseCase;
use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Domain\Entities\FoodEntity;

class UpdateFoodTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function should_be_update_a_food()
    {
        //instancias/tipos a usar
        $foodEntityType = Mockery::type(FoodEntity::class);
        $foodEntityMock = Mockery::mock(FoodEntity::class);
        //llamada a metodo de repositorio
        $foodRepositoryMock = Mockery::mock(FoodRepositoryContract::class);
        $foodRepositoryMock->shouldReceive('update')->once()->with($foodEntityType)->andReturn($foodEntityMock);

        //ejecutamos el useCase
        $useCase = new UpdateFoodUseCase($foodRepositoryMock);
        $foodResult = $useCase($foodEntityMock);

        //instancia ok
        $this->assertInstanceOf(FoodEntity::class,$foodResult);

        Mockery::getContainer()->mockery_close();
    }
}
