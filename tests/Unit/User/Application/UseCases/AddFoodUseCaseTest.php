<?php
declare(strict_types = 1);
namespace Tests\Unit\User\Application\UseCases;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\User\Application\UseCases\AddFoodUseCase;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserId;

class AddFoodUseCaseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function should_be_add_food_to_User()
    {
        //llamada a metodo de repositorio
        $userRepositoryMock = Mockery::mock(UserRepositoryContract::class);
        $userRepositoryMock->shouldReceive('addFood')->once();

        //ejecutamos el useCase
        $useCase = new AddFoodUseCase($userRepositoryMock);
        $userResult = $useCase(1,1);

        //instancia ok
        $this->assertInstanceOf(UserEntity::class,$userResult);

        Mockery::getContainer()->mockery_close();
    }
}
