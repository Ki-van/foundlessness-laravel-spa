<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVersionRequest;
use App\Http\Resources\VersionResource;
use App\Models\Article;
use App\Models\ArticleStatus;
use App\Models\Version;
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVersionRequest $request)
    {
        $validated = $request->safe()->only(['heading', 'description', 'body', 'article_id', 'version_type']);
        $validated['version_status_id'] = ArticleStatus::MODERATED_ID;
        $article = Article::findOrFail($validated['article_id']);
        $newSemVer = \PHLAK\SemVer\Version::parse($article->latestVersion()->semver);
        switch ($validated['version_type']) {
            case 'major': $newSemVer->incrementMajor(); break;
            case 'minor': $newSemVer->incrementMinor(); break;
            case 'patch': $newSemVer->incrementPatch(); break;
        }
        $validated['semver'] = $newSemVer;
       return Version::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Version  $version
     * @return VersionResource
     */
    public function show(Version $version)
    {
        return new VersionResource($version);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Version  $version
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Version $version)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Version  $version
     * @return \Illuminate\Http\Response
     */
    public function destroy(Version $version)
    {
        //
    }
}
