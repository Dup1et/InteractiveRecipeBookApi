<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $timestamp = $this->faker->dateTimeBetween(now()->subYears(2), now());
        return [
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->email,
            'language_id' => Language::on()->inRandomOrder()->first('id'),
            'updated_at' => $timestamp,
            'created_at' => $timestamp,
        ];
    }
}
