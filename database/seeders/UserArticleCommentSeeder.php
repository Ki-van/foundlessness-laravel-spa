<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class UserArticleCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::factory(10)
            ->has(Comment::factory(3)
                ->has(Comment::factory(2)->hasReplies(1), 'replies')
                )
            ->create();
    }
}
