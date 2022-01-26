<?php
declare(strict_types = 1);

namespace Tests\Unit\User\Application\UseCases;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\User\Application\UseCases\UpdateUserUseCase;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;

class UpdateUserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function should_be_update_an_user()
    {
        //instancias/tipos a usar
        $userEntityType = Mockery::type(UserEntity::class);
        $userEntityMock = Mockery::mock(UserEntity::class);
        //llamada a metodo de repositorio
        $userRepositoryMock = Mockery::mock(UserRepositoryContract::class);
        $userRepositoryMock->shouldReceive('update')->once()->with($userEntityType)->andReturn($userEntityMock);

        //ejecutamos el useCase
        $useCase = new UpdateUserUseCase($userRepositoryMock);
        $userResult = $useCase($userEntityMock);

        //instancia ok
        $this->assertInstanceOf(UserEntity::class,$userResult);

        Mockery::getContainer()->mockery_close();
    }
}
