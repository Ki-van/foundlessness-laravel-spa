<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'value' => $this->faker->randomElement([1, -1]),
            'user_id' => $this->faker->unique()->randomElement(User::all()->map(function ($user) {
                return $user->id;
            })->toArray())
        ];
    }
}
