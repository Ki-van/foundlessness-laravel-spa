<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\Mark;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MarkController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Mark::class, 'mark');
    }

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
    public function store(Request $request)
    {
         $request->validate([
            'value' => ['required',Rule::in([1, -1])],
            'markable_type' => 'required|alpha',
            'markable_id' => 'required'
        ]);
        switch ($request->input('markable_type')){
            case 'Comment': $markabkeModel = Comment::class;
                break;
            case 'Version': $markabkeModel = Version::class;
                break;
            default:
                $markabkeModel = Article::class;
        }

        return $markabkeModel::findOrFail($request->input('markable_id'))->marks()->create([
            'value'=> $request->input('value'),
            'user_id' => Auth::id(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function show(Mark $mark)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mark  $mark
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mark $mark)
    {
        return $mark->update($request->only(['value']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mark  $mark
     * @return bool
     */
    public function destroy(Mark $mark)
    {
        return $mark->delete();
    }
}
