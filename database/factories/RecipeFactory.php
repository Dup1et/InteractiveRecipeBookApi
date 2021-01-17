<?php

namespace Database\Factories;


use App\Models\Language;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $timestamp = $this->faker->dateTimeBetween(now()->subYears(2), now());
        return [
            'title' => $this->faker->text(64),
            'description' => $this->faker->text(500),
            'cooking_time' => $this->faker->time(),
            'portions' => $this->faker->numberBetween(1, 5),
            'language_id' => Language::on()->inRandomOrder()->first('id'),
            'body' => json_encode([
                'test_field1' => $this->faker->text('64'),
                'test_field2' => $this->faker->randomNumber(),
            ]),
            'user_id' => User::on()->inRandomOrder()->first('id'),
            'updated_at' => $timestamp,
            'created_at' => $timestamp,
        ];
    }
}
