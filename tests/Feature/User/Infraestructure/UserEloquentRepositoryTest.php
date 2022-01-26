<?php
declare(strict_types=1);

namespace Tests\Feature\User\Infraestructure;

use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\UnauthorizedException;
use Src\Food\Domain\ValueObjects\FoodId;
use Src\User\Domain\Entities\UserEntity;
use Src\User\Domain\ValueObjects\UserEmail;
use Src\User\Domain\ValueObjects\UserId;
use Src\User\Domain\ValueObjects\UserLastName;
use Src\User\Domain\ValueObjects\UserName;
use Src\User\Domain\ValueObjects\UserPassword;
use Src\User\Infraestructure\Repositories\UserEloquentRepository;
use Tests\TestCase;

class UserEloquentRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private UserEloquentRepository $repository;

    protected function setUp(): void
    {
        $this->repository = new UserEloquentRepository();
        parent::setUp();
    }

    /**
     * @test
     */
    public function it_save_an_user()
    {
        //given -- Teniendo 0 usuarios en base de datos
        $userList = User::all();
        $this->assertCount(0, $userList);

        //when -- cuando llamamamos al metodo save
        $entity = new UserEntity(
            new UserId(1),
            new UserName("Test"),
            new UserLastName("Test"),
            new UserEmail("test@test.com"),
            new UserPassword("password")
        );

        $entitySaved = $this->repository->save($entity);

        //then -- deberíamos tener 1 registro en base de datos
        $userList = User::all();
        $this->assertCount(1, $userList);
    }

    /**
     * @test
     */
    public function it_return_an_user()
    {
        //given -- Teniendo 10 usuarios en base de datos
        $userList = User::factory(10)->create();
        //cuando busquemos el id 1
        $entityFound = $this->repository->find(new UserId(1));
        $this->assertEquals(1, $entityFound->getId()->value());
    }

    /**
     * @test
     */
    public function it_not_return_an_user()
    {
        $this->expectException(ModelNotFoundException::class);
        //given -- Teniendo 10 usuarios en base de datos
        $userList = User::factory(10)->create();
        //cuando busquemos el id 1
        $entityFound = $this->repository->find(new UserId(50));
        //debería devolver una exception
    }


    /**
     * @test
     */
    public function it_login()
    {
        //given -- Teniendo 1 usuario en base de datos con el email test@test.com
        User::factory(1)->create([
            "email" => "test@test.com"
        ]);
        //cuando busquemos por el usuario y contraseña
        $entityFound = $this->repository->findByEmailAndPassword(
            new UserEmail("test@test.com"),
            new UserPassword("password")
        );

        $this->assertNotNull($entityFound);
    }

    /**
     * @test
     */
    public function it_not_login_with_wrong_password()
    {
        $this->expectException(UnauthorizedException::class);
        //given -- Teniendo 1 usuario en base de datos con el email test@test.com
        User::factory(1)->create([
            "email" => "test@test.com"
        ]);
        //cuando busquemos por el usuario y contraseña
        $entityFound = $this->repository->findByEmailAndPassword(
            new UserEmail("test@test.com"),
            new UserPassword("passwordFalse")
        );
    }

    /**
     * @test
     */
    public function it_not_login_with_wrong_email()
    {
        $this->expectException(UnauthorizedException::class);
        //given -- Teniendo 1 usuario en base de datos con el email test@test.com
        User::factory(1)->create([
            "email" => "test@test.com"
        ]);
        //cuando busquemos por el usuario y contraseña
        $entityFound = $this->repository->findByEmailAndPassword(
            new UserEmail("testWrong@test.com"),
            new UserPassword("password")
        );
    }

    /**
     * @test
     */
    public function it_update_user_to_admin()
    {
        //given -- Teniendo 1 usuarios en base de datos
        User::factory(10)->create();
        //cuando llamemos al metodo con el id 1
        $this->repository->toAdmin(new UserId(1));
        $user = User::find(1);
        //debería ser admin
        $this->assertTrue($user->isAdmin);
    }

    /**
     * @test
     */
    public function it_not_update_user_to_admin()
    {
        $this->expectException(ModelNotFoundException::class);
        //given -- Teniendo 1 usuarios en base de datos
        User::factory(1)->create();
        //cuando llamemos al metodo con el id 1
        $this->repository->toAdmin(new UserId(2));
    }

    /**
     * @test
     */
    public function it_update_user()
    {
        //given -- Teniendo 1 usuarios en base de datos
        User::factory(1)->create();
        //cuando llamemos al metodo con el id 1
        $userToEdit = new UserEntity(
            new UserId(1),
            new UserName("Test"),
            new UserLastName("Test2"),
            new UserEmail("test3@email.com"),
            new UserPassword(""),
        );
        $this->repository->update($userToEdit);

        $user = User::find(1);

        //debería ser los valores iguales
        $this->assertEquals("Test", $user->name);
        $this->assertEquals("Test2", $user->lastName);
        $this->assertEquals("test3@email.com", $user->email);
    }

    /**
     * @test
     */
    public function it_not_update_user()
    {
        $this->expectException(ModelNotFoundException::class);
        //given -- Teniendo 1 usuarios en base de datos
        User::factory(1)->create();
        //cuando llamemos al metodo con el id 1
        $userToEdit = new UserEntity(
            new UserId(2),
            new UserName("Test"),
            new UserLastName("Test2"),
            new UserEmail("test3@email.com"),
            new UserPassword(""),
        );
        $this->repository->update($userToEdit);
    }

    /**
     * @test
     */
    public function it_return_user_withFoods()
    {
        User::factory(1)->create();
        Food::factory(1)->create();
        $user_before = User::find(1);
        $user_before->foods()->attach(1);

        $user_after = User::find(1)->with("foods")->first();

        $this->assertCount(1, $user_after->foods);
    }

    /**
     * @test
     */
    public function it_add_a_food_on_user()
    {
        //given -- Teniendo 1 usuarios en base de datos
        User::factory(1)->create();
        Food::factory(1)->create();
        //cuando llamemos al metodo con el id 1
        $this->repository->addFood(new UserId(1), new FoodId(1));

        $user = User::find(1)->with('foods')->first();

        //debería ser los valores iguales
        $this->assertCount(1, $user->foods);

    }

    /**
     * @test
     */
    public function it_not_add_a_food_on_user()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->addFood(new UserId(2), new FoodId(2));
    }

    /**
     * @test
     */
    public function it_remove_a_food_on_user()
    {
        //given -- Teniendo 1 usuarios en base de datos
        User::factory(1)->create();
        Food::factory(1)->create();
        //cuando llamemos al metodo con el id 1
        $user = User::find(1);
        $user->foods()->attach(1);

        $this->repository->removeFood(new UserId(1), new FoodId(1));

        $user = User::find(1)->with('foods')->first();

        //debería ser los valores iguales
        $this->assertCount(0, $user->foods);
    }

    /**
     * @test
     */
    public function it_not_remove_a_food_on_user()
    {
        $this->expectException(ModelNotFoundException::class);
        $this->repository->removeFood(new UserId(1), new FoodId(1));
    }
}
