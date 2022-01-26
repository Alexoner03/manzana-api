<?php
declare(strict_types=1);

namespace Food\Application\UseCases;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Food\Application\UseCases\CreateFoodUseCase;
use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Domain\Entities\FoodEntity;

class CreateFoodTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_create_a_food()
    {
        //instancias/tipos a usar
        $foodEntityType = Mockery::type(FoodEntity::class);
        $foodEntityMock = Mockery::mock(FoodEntity::class);
        $foodEntityMock->shouldReceive('create')->once();

        //llamada a metodo de repositorio
        $foodRepositoryMock = Mockery::mock(FoodRepositoryContract::class);
        $foodRepositoryMock->shouldReceive('save')->once()->with($foodEntityType)->andReturn($foodEntityMock);

        //ejecutamos el useCase
        $useCase = new CreateFoodUseCase($foodRepositoryMock);
        $foodResult = $useCase(
            "Nombre",
            "Description",
            "fakePath"
        );

        //instancia ok
        $this->assertInstanceOf(FoodEntity::class,$foodResult);

        Mockery::getContainer()->mockery_close();
    }
}
