<?php

namespace Database\Factories;

use App\Models\ArticleStatus;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'domain_id' => $this->faker->randomElement([
                'out_of_domain',
                'math',
                'philosophy_of_it',
                'philosophy',
                'it'
            ]),
            'user_id' => User::factory()->hasAttached(Role::findByName('User')),
            'slug' => $this->faker->unique()->word,
        ];
    }
}
