<?php

namespace Database\Seeders;

use App\Models\Recipe;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestRecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            DB::unprepared('SET FOREIGN_KEY_CHECKS = 0;');

            Recipe::on()->truncate();

            $faker = Factory::create();

            $now = Carbon::now()->toDateTimeString();

            for ($i = 0; $i < 50; $i++) {
                Recipe::on()->insert([
                    'title' => $faker->unique()->name,
                    'description' => $faker->text('255'),
                    'cooking_time' => $faker->time(),
                    'portions' => $faker->numberBetween(1, 5),
                    'language_id' => 1,
                    'recipe_body_id' => $faker->unique()->numberBetween(),
                    'user_id' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        });
    }
}
