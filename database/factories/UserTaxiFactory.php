<?php

namespace Database\Factories;

use App\Models\Taxi;
use App\Models\User;
use App\Models\UserTaxi;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTaxiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserTaxi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'color'  => $this->faker->randomElement(['red', 'blue', 'yellow']),
            'user_id'   => User::factory(), // Use the User factory to create a random user
            'taxi_id' => Taxi::factory(), // Use the Taxi factory to create a random taxi
            'price' => $this->faker->numberBetween(1, 10),
        ];
    }
}
