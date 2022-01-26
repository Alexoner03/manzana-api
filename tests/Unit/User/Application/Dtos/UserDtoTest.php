<?php
declare(strict_types = 1);

namespace Tests\Unit\User\Application\Dtos;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\User\Application\Dtos\UserDto;
use Src\User\Domain\Entities\UserEntity;

class UserDtoTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @test
     */
    public function should_be_create_an_user()
    {
        $entity = Mockery::mock(UserEntity::class);
        $entity->shouldReceive('getId')->once();
        $entity->shouldReceive('getName')->once();
        $entity->shouldReceive('getLastName')->once();
        $entity->shouldReceive('getEmail')->once();
        $entity->shouldReceive('getIsAdmin')->once();
        $entity->shouldReceive('getFoods')->once();

        $newInstance = UserDto::mapFromUserEntity($entity);
        $this->assertInstanceOf(UserDto::class,$newInstance);

        Mockery::getContainer()->mockery_close();
    }
}
