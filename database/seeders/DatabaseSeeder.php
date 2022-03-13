<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            TagSeeder::class,
            ArticleStatusesSeeder::class,
            DomainSeeder::class,
            UserArticleCommentSeeder::class
        ]);
    }
}
