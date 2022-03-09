<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\StoreVersionRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleStatus;
use App\Models\Domain;
use App\Models\User;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        /*$request->validate([
           'status'=>'sometimes|require|exists:article_statuses,status',
           'user_id'=>'sometimes|require|exists:users,id'
        ]);*/

        return ArticleResource::collection(
            Article::where('article_status_id', '=', ArticleStatus::PUBLISHED_ID)
            ->orderByDesc('created_at')
                ->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return ArticleResource
     */
    public function store(StoreArticleRequest $request)
    {
        $version = $request['version'];
        Validator::validate($version, [
            'heading' => 'required|max:255',
            'description' => 'required|min:20|max:511',
            'body' => 'required',
        ]);

        $validated = $request->safe()->only([ 'domain_id']);
        $validated['user_id'] = Auth::id();
        $validated['article_status_id'] = ArticleStatus::MODERATED_ID;

        $article = Article::create($validated);
        $article->tags()->attach($request->safe()->only('tag_ids'));
        Version::create([
            'heading' => $version['heading'],
            'description' => $version['description'],
            'body' => $version['body'],
            'version_status_id' => ArticleStatus::MODERATED_ID,
            'semver'=>'1.0.0',
            'article_id'=>$article->id,
        ]);
        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return ArticleResource
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        Gate::authorize('update', $article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }
}
