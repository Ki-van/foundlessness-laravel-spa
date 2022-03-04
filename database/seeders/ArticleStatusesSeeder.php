<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ArticleStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            'published',
            'moderated',
            'hidden',
            'creating'
        ];

        foreach ($statuses as $status) {
            $input = [
                'status' => $status
            ];
            DB::table('article_statuses')->insert($input);
        }
    }
}
