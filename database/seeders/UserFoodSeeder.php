<?php

namespace Database\Seeders;

use App\Models\Food;
use App\Models\User;
use Illuminate\Database\Seeder;
use function React\Promise\all;

class UserFoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $foods = Food::all();

        foreach ($users as $user){
            foreach ($foods as $food){
                $user->foods()->attach($food->id);
            }
        }
    }
}
