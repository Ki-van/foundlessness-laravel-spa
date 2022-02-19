<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserArticleCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=>'Admin']);
        Role::create(['name'=>'User']);

        Article::factory(10)
            ->has(Comment::factory(3)
                ->has(Comment::factory(2)->hasReplies(1), 'replies')
                )
            ->create();

        /**
         * @var $user User
         */
        $user = User::factory()->create([
            'name' => 'kivan',
            'email'=>'kirill.ivanin00@yandex.ru',
            'password' => Hash::make('kivan'),
        ]);

        $user->assignRole('Admin');
    }
}
