<?php
declare(strict_types=1);

namespace Tests\Unit\User\Application\UseCases;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\User\Application\Dtos\UserDto;
use Src\User\Application\UseCases\SetAdminUseCase;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserId;

class SetAdminTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_update_an_user()
    {
        //instancias a usar
        $userId = Mockery::type(UserId::class);
        $userEntityType = Mockery::type(UserEntity::class);

        //Entidad que será actualizada
        $userEntity = Mockery::mock(UserEntity::class);
        $userEntity->shouldReceive('getId')->once();
        $userEntity->shouldReceive('getName')->once();
        $userEntity->shouldReceive('getLastName')->once();
        $userEntity->shouldReceive('getEmail')->once();
        $userEntity->shouldReceive('getIsAdmin')->once();
        $userEntity->shouldReceive('getFoods')->once();

        //instancia de repositorio
        $repositoryMock = Mockery::mock(UserRepositoryContract::class);
        $repositoryMock->shouldReceive('toAdmin')->once()->with($userId)->andReturn($userEntity);

        //mapeo de entidad a DTO
        $userDtoMock = Mockery::mock(UserDto::class);
        $userDtoMock->shouldReceive('mapFromUserEntity')->once()->with($userEntityType)->andReturnSelf();

        //instanciandoUseCase
        $useCase = new SetAdminUseCase($repositoryMock);
        //ejecutamos useCase
        $entity = $useCase(1);
        //instancia ok
        $this->assertInstanceOf(UserDto::class,$entity);

        Mockery::getContainer()->mockery_close();
    }
}
