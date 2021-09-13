<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {
        $validated = $request->validated();
        $comment = Comment::create([
            'user_id' => auth()->id(),
            'ticket_id' => $validated['ticket_id'],
            'content' => $validated['content']
        ]);

        return response()->json($comment, 201);

    }
}
