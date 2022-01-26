<?php
declare(strict_types=1);

namespace Tests\Unit\User\Domain\Entities;

use PHPUnit\Framework\TestCase;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserLastName;
use Src\User\Domain\ValueObjects\UserName;
use Src\User\Domain\ValueObjects\UserPassword;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function should_create_an_object()
    {
        //el test debería crear una instancia correctamente
        $userNameMock = $this->createMock(UserName::class);
        $userLastNameMock = $this->createMock(UserLastName::class);
        $userEmailMock = $this->createMock(UserEmail::class);
        $userPasswordMock = $this->createMock(UserPassword::class);
        $userIdMock = $this->createMock(UserId::class);

        $instance = UserEntity::create(
            $userIdMock,
            $userNameMock,
            $userLastNameMock,
            $userEmailMock,
            $userPasswordMock,
        );
        //instancia ok
        $this->assertInstanceOf(UserEntity::class, $instance);
    }
}
