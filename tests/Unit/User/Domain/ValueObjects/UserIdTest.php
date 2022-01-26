<?php
declare(strict_types=1);

namespace Tests\Unit\User\Application\UseCases\User\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use Src\User\Domain\ValueObjects\UserId;

class UserIdTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function should_create_an_object()
    {
        //el test debería crear una instancia correctamente
        $value = 1;
        $instance = new UserId($value);
        $this->assertInstanceOf(UserId::class, $instance);

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
        $value = 0; //invalid id
        new UserId($value);

    }
}
