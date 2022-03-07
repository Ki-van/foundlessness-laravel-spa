<?php

namespace Database\Factories;

use App\Models\ArticleStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->paragraph(2),
            'user_id' => $this->faker->randomElement(ArticleStatus::all('id')
                ->map(fn($val) => $val['id'])->toArray())
        ];
    }
}
