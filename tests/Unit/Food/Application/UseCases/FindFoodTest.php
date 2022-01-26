<?php
declare(strict_types=1);

namespace Food\Application\UseCases;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Food\Application\UseCases\FindFoodUseCase;
use Src\Food\Domain\Contracts\FoodRepositoryContract;
use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\ValueObjects\FoodId;

class FindFoodTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_return_a_food()
    {
        //instancias/tipos a usar
        $foodIdType = Mockery::type(FoodId::class);
        $foodEntityMock = Mockery::mock(FoodEntity::class);

        //llamada a metodo de repositorio
        $foodRepositoryMock = Mockery::mock(FoodRepositoryContract::class);
        $foodRepositoryMock->shouldReceive('find')->once()->with($foodIdType)->andReturn($foodEntityMock);

        //ejecutamos el useCase
        $useCase = new FindFoodUseCase($foodRepositoryMock);
        $foodResult = $useCase(1);

        //instancia ok
        $this->assertInstanceOf(FoodEntity::class,$foodResult);

        Mockery::getContainer()->mockery_close();
    }
}
