<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleModerateResource;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleStatus;
use App\Models\Version;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ModerationController extends Controller
{
    public function __construct()
    {

    }

    /**
     * @Annotation Return all articles that can be moderated
     * @return AnonymousResourceCollection
     */
    public function index()
    {

        return ArticleModerateResource::collection(
            Article::where('user_id', '<>', Auth::id())
                ->whereIn('domain_id', Auth::user()->moderatedDomains())
                ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('versions')
                ->whereRaw('versions.article_id = articles.id')
                ->where('versions.version_status_id','=', ArticleStatus::MODERATED_ID);
        })->orderByDesc('updated_at')
            ->get());
    }

    /**
     * Display the specified resource.
     *
     * @param Article $article
     * @return ArticleModerateResource
     */
    public function show(Article $article)
    {
        if(!Auth::user()->hasPermissionTo('moderate '.$article->domain_id))
            abort(403);

        return new ArticleModerateResource($article);
    }

    /**
     * Set version status to published
     *
     * @param Version $version
     * @return JsonResponse
     */
    public function publish(Version $version)
    {
        if(!Auth::user()->hasPermissionTo('moderate '.$version->article->domain_id) && $version->article->user_id !== Auth::id())
            abort(403);
        $version->version_status_id = ArticleStatus::PUBLISHED_ID;
        $version->save();

        return new JsonResponse(null, 200);
    }
}
