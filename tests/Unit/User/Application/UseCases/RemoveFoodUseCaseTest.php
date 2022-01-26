<?php

namespace Tests\Unit\User\Application\UseCases;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\User\Application\UseCases\RemoveFoodUseCase;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;

class RemoveFoodUseCaseTest extends TestCase
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
        $userRepositoryMock->shouldReceive('removeFood')->once();

        //ejecutamos el useCase
        $useCase = new RemoveFoodUseCase($userRepositoryMock);
        $userResult = $useCase(1,1);

        //instancia ok
        $this->assertInstanceOf(UserEntity::class,$userResult);

        Mockery::getContainer()->mockery_close();
    }
}
