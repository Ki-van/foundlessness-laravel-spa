<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = [
            'Философия',
            'Математика',
            'ИИ',
            'Мировозрение'
        ];

        foreach ($tags as $tag) {
            $input = [
                'name' => $tag
            ];
            DB::table('tags')->insert($input);
        }
    }
}
