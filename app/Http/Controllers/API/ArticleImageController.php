<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class ArticleImageController extends Controller
{
    public function uploadFile(Request $request)
    {
        try {
            $path = $request->file('image')->storePublicly('images/article-related', 'public');

            return response()->json([
                'success' => 1,
                'file' => [
                    'url' => asset('/storage/'.$path)
                ],
            ]);
        }catch (\Exception $exception)
        {
            return response()->json([
                'success' => 0
            ]);
        }
    }
}
