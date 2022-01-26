<?php
declare(strict_types=1);

namespace Tests\Feature\Food\Infraestructure;

use App\Models\Food;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Src\Food\Domain\Entities\FoodEntity;
use Src\Food\Domain\ValueObjects\FoodDescription;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\Food\Domain\ValueObjects\FoodImagePath;
use Src\Food\Domain\ValueObjects\FoodName;
use Src\Food\Infraestructure\Repositories\FoodEloquentRepository;
use Tests\TestCase;

class FoodEloquentRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private FoodEloquentRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new FoodEloquentRepository();
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_save_a_food()
    {
        //given -- Teniendo 0 registros en base de datos
        $list = Food::all();
        $this->assertCount(0, $list);

        //when -- cuando llamamamos al metodo save
        $entity = new FoodEntity(
            new FoodId(1),
            new FoodDescription("Test Description"),
            new FoodName("test"),
            new FoodImagePath("/fake/path"),
        );

        $this->repository->save($entity);

        //then -- deberíamos tener 1 registro en base de datos
        $foodList = Food::all();
        $food = $foodList->first();
        $this->assertCount(1, $foodList);
        $this->assertEquals("Test Description",$food->description);
        $this->assertEquals("test",$food->name);
        $this->assertEquals("/fake/path",$food->imagePath);
    }

    /**
     * @test
     */
    public function it_returns_a_food()
    {
        //given -- Teniendo 10 usuarios en base de datos
        Food::factory(10)->create();
        //cuando busquemos el id 1
        $entityFound = $this->repository->find(new FoodId(1));
        $this->assertEquals(1, $entityFound->getId()->value());
    }

    /**
     * @test
     */
    public function it_not_returns_a_food()
    {
        $this->expectException(ModelNotFoundException::class);
        //given -- Teniendo 10 usuarios en base de datos
        Food::factory(10)->create();
        //cuando busquemos el id 1
        $entityFound = $this->repository->find(new FoodId(20));
    }

    /**
     * @test
     */
    public function it_updates_a_food()
    {
        //given -- Teniendo 1 usuarios en base de datos
        Food::factory(1)->create();
        //cuando llamemos al metodo con el id 1
        $foodToEdit = new FoodEntity(
            new FoodId(1),
            new FoodDescription("Test"),
            new FoodName("Test2"),
            new FoodImagePath("/fakePath"),
        );
        $this->repository->update($foodToEdit);

        $food = Food::find(1);

        //debería ser los valores iguales
        $this->assertEquals("Test",$food->description);
        $this->assertEquals("Test2",$food->name);
        $this->assertEquals("/fakePath",$food->imagePath);
    }

    /**
     * @test
     */
    public function it_not_update_a_food()
    {
        $this->expectException(ModelNotFoundException::class);
        //given -- Teniendo 1 usuarios en base de datos
        Food::factory(1)->create();
        //cuando llamemos al metodo con el id 1
        $foodToEdit = new FoodEntity(
            new FoodId(2),
            new FoodDescription("Test"),
            new FoodName("Test2"),
            new FoodImagePath("/fakePath"),
        );
        $this->repository->update($foodToEdit);
    }

    /**
     * @test
     */
    public function it_list_10_items()
    {
        Food::factory(10)->create();
        $foods = $this->repository->list();

        $this->assertEquals(10, $foods->size());

        foreach ($foods as $food){
            $this->assertInstanceOf(FoodEntity::class,$food);
        }
    }

    /**
     * @test
     */
    public function it_list_0_items()
    {
        $foods = $this->repository->list();
        $this->assertEquals(0, $foods->size());
    }
}
