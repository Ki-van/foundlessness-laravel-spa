<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_article()
    {
        $article = Article::factory()->make();
        $response = $this->postJson('api/article', $article->toArray());
        print($response->dd());
        $this->assertModelExists($article);
        $response->assertStatus(200);
    }
}
