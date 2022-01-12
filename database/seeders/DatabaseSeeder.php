<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('article_statuses')->insert([
            'id' => 1,
            'status' => 'published'
        ]);

        DB::table('article_statuses')->insert([
            'id' => 2,
            'status' => 'moderated'
        ]);

        DB::table('article_statuses')->insert([
            'id' => 3,
            'status' => 'hidden'
        ]);

        DB::table('article_statuses')->insert([
            'id' => 4,
            'status' => 'deleted'
        ]);

        DB::table('article_statuses')->insert([
            'id' => 5,
            'status' => 'creating'
        ]);
    }
}
