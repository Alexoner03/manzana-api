<?php
declare(strict_types=1);

namespace Tests\Unit\User\Application\UseCases;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\User\Application\Dtos\UserDto;
use Src\User\Application\UseCases\LoginUseCase;
use Src\User\Domain\Contracts\UserRepositoryContract;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserPassword;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function should_be_return_user()
    {
        //instancias a usar
        $userEmail = Mockery::type(UserEmail::class);
        $userPassword = Mockery::type(UserPassword::class);
        //creacion de objeto a buscar
        $userEntity = Mockery::mock(UserEntity::class);
        $userEntity->shouldReceive('getId')->once();
        $userEntity->shouldReceive('getName')->once();
        $userEntity->shouldReceive('getLastName')->once();
        $userEntity->shouldReceive('getEmail')->once();
        $userEntity->shouldReceive('getIsAdmin')->once();
        $userEntity->shouldReceive('getFoods')->once();

        //llamada a repositorio
        $repositoryMock = Mockery::mock(UserRepositoryContract::class);
        $repositoryMock->shouldReceive('findByEmailAndPassword')->with($userEmail, $userPassword)->andReturn($userEntity);

        //instanciamos el useCase
        $useCase = new LoginUseCase($repositoryMock);
        //Ejecutamos el useCase
        $userDto = $useCase("test@test.com","password");
        //validar Instancia
        $this->assertInstanceOf(UserDto::class, $userDto);

        Mockery::getContainer()->mockery_close();
    }
}
