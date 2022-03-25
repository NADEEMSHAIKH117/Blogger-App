<?php

namespace App\Http\Controllers;

use App\Models\blog;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class BlogController extends Controller
{
    
    public function createBlog(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'blog' => 'required|string|between:3,1000',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        try
        {
        $blog = new blog;
        $blog->blog = $request->input('blog');
        $blog->user_id = Auth::user()->id;
        $blog->save();
        }
        catch (Exception $e)
        {
            return response()->json([
                'status' => 404,
                'message' => 'Invalid authorization token'
            ], 404);
        }
        return response()->json([
            'status' => 201,
            'message' => 'blog created successfully'
            ],201);
    }

    public function displayBlogById(Request $request)
    {
        
            $currentUser = JWTAuth::parseToken()->authenticate();

            if ($currentUser) {
                $user = blog::leftJoin('comment_blogs', 'comment_blogs.blog_id', '=', 'blogs.id')
                              ->leftJoin('comments', 'comments.id', '=', 'comment_blogs.comment_id')
                              ->select('blogs.id', 'blogs.blog', 'comments.comments')
                              ->where('blogs.user_id', '=', $currentUser->id)->get();
                
            }
            if ($user == '[]') {
                return response()->json(['message' => 'blog not found'], 404);
            }

            return response()->json([
                'message' => 'All Notes are Fetched Successfully',
                'Notes' => $user
            ], 200);
        
    }

}
