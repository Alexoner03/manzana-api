<?php
declare(strict_types=1);

namespace Food\Domain\Entities;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\ValueObjects\FoodDescription;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\Food\Domain\ValueObjects\FoodImagePath;
use Src\Food\Domain\ValueObjects\FoodName;

class FoodTest extends TestCase
{
    /**
     * @test
     */
    public function should_be_create_an_object()
    {
        //recibimos valores ok
        $food = new FoodEntity(
            new FoodId(1),
            new FoodDescription("Test"),
            new FoodName("Test"),
            new FoodImagePath("Test")
        );

        //propiedades deberían coincidir
        $this->assertEquals(1, $food->getId()->value());
        $this->assertEquals("Test", $food->getName()->value());
        $this->assertEquals("Test", $food->getDescription()->value());
        $this->assertEquals("Test", $food->getImagePath()->value());

    }

    /**
     * @test
     */
    public function should_not_be_create_an_object()
    {
        //esperamos una exception al ingresar propiedad no valida
        $this->expectException(InvalidArgumentException::class);

        new FoodEntity(
            new FoodId(0), //propiedad no valida menor a 0
            new FoodDescription("Test"),
            new FoodName("Test"),
            new FoodImagePath("Test")
        );
    }
}
