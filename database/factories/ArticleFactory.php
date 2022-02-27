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
            'heading' => $this->faker->sentence,
            'description' => $this->faker->paragraph(2),
            'body' => [
                'time' => 1645688351878,
                'blocks' => array([
                    'id' => '7Jpc-aBF3q',
                    'data' => [
                        'text' => $this->faker->paragraph(3)
                    ],
                    "type" => "paragraph",
                    "version" => "2.23.2"
                ])
            ],
            'domain_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'article_status_id' => $this->faker->randomElement(ArticleStatus::all('id')
                ->map(fn($val) => $val['id'])->toArray()),
            'user_id' => User::factory()->hasAttached(Role::findByName('User')),
            'slug' => $this->faker->unique()->word,
        ];
    }
}
