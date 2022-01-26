<?php
declare(strict_types=1);

namespace Food\Domain\ValueObjects;

use PHPUnit\Framework\TestCase;
use Src\Food\Domain\ValueObjects\FoodId;

class FoodIDTest extends TestCase
{
    /**
     * @test
     * @return void
     */
    public function should_create_an_object()
    {
        //el test debería crear una instancia correctamente
        $value = 1;
        $instance = new FoodId($value);
        $this->assertInstanceOf(FoodId::class, $instance);

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
        new FoodId($value);

    }
}
