<?php

namespace App\Http\Controllers;

use App\Models\commentBlog;
use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class CommentsController extends Controller
{
    public function createComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comments' => 'required|string|between:2,15',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();

        if ($user) {
            $comment = comments::where('comments', $request->comments)->first();
            if ($comment) {
                return response()->json([
                    'message' => 'comment already exists'
                ], 401);
            }

            $comments = new comments;
            $comments->comments = $request->get('comments');

            if ($user->comments()->save($comments)) {
                return response()->json([
                    'status' => 201,
                    'message' => 'comment added Sucessfully',
                ], 201);
            }
        }
        return response()->json([
            'status' => 401,
            'message' => 'Invalid authorization token'
        ], 401);
    }

    public function displayCommentsById()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $comment = comments::where('user_id', '=', $user->id)->get();
        if ($comment == '') {
            return response()->json(['message' => 'comment not Found'], 404);
        }

        return response()->json([
            'message' => 'All Labels are Fetched Successfully',
            'label' => $comment
        ], 200);
    }

    public function addCommentByNoteId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment_id' => 'required',
            'blog_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = JWTAuth::parseToken()->authenticate();

        if ($user) {
            $commentblog = commentBlog::where('blog_id', $request->blog_id)->where('comment_id', $request->comment_id)->first();
            if ($commentblog) {
                return response()->json([
                    'status' => 409,
                    'message' => 'Note Already have a label'
                ], 409);
            }

            $commentblogs = new commentBlog();
            $commentblogs->comment_id = $request->comment_id;
            $commentblogs->blog_id = $request->blog_id;

            if ($user->commentblog()->save($commentblogs)) {
                return response()->json([
                    'status' => 201,
                    'message' => 'comment to blog added Successfully',
                ], 201);
            }
        }

        return response()->json([
            'status' => 401,
            'message' => 'Invalid authorization token'
        ], 401);
    }
}
