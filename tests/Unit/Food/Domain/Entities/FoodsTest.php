<?php
declare(strict_types=1);

namespace Food\Domain\Entities;

use Mockery;
use PHPUnit\Framework\TestCase;
use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\Entities\FoodsEntity;

class FoodsTest extends TestCase
{
    public function tearDown(): void
    {
        Mockery::getContainer()->mockery_close();
    }

    /**
     * @test
     */
    public function should_create_an_object()
    {
        //al crear una nueva collecion el tamaño deberia ser 0
        $foods = new FoodsEntity();
        $this->assertEquals(0,$foods->size());
    }

    /**
     * @test
     */
    public function should_add_item()
    {
        //al agregar una entidad FoodEntity el tamaño debe aumentar en 1
        $foods = new FoodsEntity();
        $this->assertEquals(0,$foods->size());
        $foods->add($this->createMock(FoodEntity::class));
        $this->assertEquals(1,$foods->size());
    }
}
