<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVersionRequest;
use App\Http\Resources\VersionResource;
use App\Models\Article;
use App\Models\ArticleStatus;
use App\Models\Version;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVersionRequest $request)
    {
        $validated = $request->safe()->only(['heading', 'description', 'body', 'article_id', 'version_type']);
        $validated['version_status_id'] = ArticleStatus::MODERATED_ID;
        $article = Article::findOrFail($validated['article_id']);
        $newSemVer = \PHLAK\SemVer\Version::parse($article->latestVersion(null)->semver);
        switch ($validated['version_type']) {
            case 'major': $newSemVer->incrementMajor(); break;
            case 'minor': $newSemVer->incrementMinor(); break;
            case 'patch': $newSemVer->incrementPatch(); break;
        }
        $validated['semver'] = $newSemVer;
       $version =  Version::create($validated);
       $article->updated_at = now(); //TODO: TEST IT IDIOT!!!
       $article->save();
       return $version;
    }

    /**
     * Display the specified resource.
     *
     * @param Version $version
     * @return VersionResource
     */
    public function show(Version $version)
    {
        return new VersionResource($version);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Version $version
     * @return JsonResponse
     */
    public function update(Request $request, Version $version): JsonResponse
    {
        $request->validate([
            'version_status_id'=>'required|exists:article_statuses,id'
        ]);

        $version->setAttribute('version_status_id', $request->input('version_status_id'));
        $version->save();
        return new JsonResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Version $version
     * @return \Illuminate\Http\Response
     */
    public function destroy(Version $version)
    {
        //
    }
}
