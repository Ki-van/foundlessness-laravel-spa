<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
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
     * @return CommentResource
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
            'comment_id' => 'sometimes|required|exists:comments,id',
            'commentable_type' => 'sometimes|required|alpha',
            'commentable_id' => 'sometimes|required|exists:versions,id'
        ]);

        if($request->has('comment_id'))
            return new CommentResource(Comment::create(
                $request->collect(['body', 'comment_id'])
                ->merge(['user_id'=>Auth::id()])
                    ->toArray()));

        switch ($request->input('commentable_type')){
            default:
                $commentableModel = Version::class;
        }

        return new CommentResource($commentableModel::findOrFail($request->input('commentable_id'))
            ->comments()
            ->create([
            'body'=> $request->input('body'),
            'user_id'=>Auth::id()
        ]));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
