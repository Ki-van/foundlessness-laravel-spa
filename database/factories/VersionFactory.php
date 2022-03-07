<?php

namespace Database\Factories;

use App\Models\ArticleStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class VersionFactory extends Factory
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
            'version_status_id' => $this->faker->randomElement(ArticleStatus::all('id')
                ->map(fn($val) => $val['id'])->toArray()),
            'semver' => $this->faker->semver()
        ];
    }
}
