<?php
declare(strict_types=1);

namespace Tests\Unit\User\Application\UseCases;

use JetBrains\PhpStorm\Pure;
use PHPUnit\Framework\TestCase;
use Src\User\Application\Dtos\UserDto;
use Src\User\Application\UseCases\CreateUserUseCase;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Mockery;
use Src\User\Domain\Entities\UserEntity;

class CreateUserTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::getContainer()->mockery_close();
    }

    /**
     * @test
     */
    public function should_be_create_an_user(): void
    {
        //creando instancia a guardar
        $userCreatedType = Mockery::type(UserEntity::class);
        $userCreatedMock = Mockery::mock(UserEntity::class);

        //llamadas a getters
        $userCreatedMock->shouldReceive('create')->once();
        $userCreatedMock->shouldReceive('getId')->once();
        $userCreatedMock->shouldReceive('getName')->once();
        $userCreatedMock->shouldReceive('getLastName')->once();
        $userCreatedMock->shouldReceive('getEmail')->once();
        $userCreatedMock->shouldReceive('getIsAdmin')->once();
        $userCreatedMock->shouldReceive('getFoods')->once();

        //llamada a repositorio
        $repositoryMock = Mockery::mock(UserRepositoryContract::class);
        $repositoryMock->shouldReceive('save')->once()->with($userCreatedType)->andReturn($userCreatedMock);

        //mapear entidad a DTO
        $userDtoMock = Mockery::mock(UserDto::class);
        $userDtoMock->shouldReceive('mapFromUserEntity')->once()->with($userCreatedMock);

        //ejecutamos el caso de uso
        $useCase = new CreateUserUseCase($repositoryMock);
        $dto = $useCase("test", "test", "test@test.com", "test",);
        //instancia ok
        $this->assertInstanceOf(UserDto::class, $dto);

    }
}
