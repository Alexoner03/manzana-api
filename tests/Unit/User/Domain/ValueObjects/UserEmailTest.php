<?php
declare(strict_types=1);

namespace Tests\Unit\User\Application\UseCases\User\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use Src\User\Domain\ValueObjects\UserEmail;

class UserEmailTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function should_create_an_object()
    {
        //el test debería crear una instancia correctamente
        $value = "test@test.com";
        $instance = new UserEmail($value);
        $this->assertInstanceOf(UserEmail::class, $instance);

        //la instancia creada debería tener el valor seteado
        $this->assertTrue($instance->value() === $value);

    }

    /**
     * @test
     */
    public function should_not_create_an_object()
    {
        $this->expectException(\InvalidArgumentException::class);

        //el test no debería crear una instancia correctamente
        $value = "12345"; //invalid email
        new UserEmail($value);

    }
}
