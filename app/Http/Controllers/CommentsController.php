<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Mail\CreateCommentMail;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCommentRequest $request)
    {
        $comment = Comment::create($request->all());
        $postComments = $comment->post->comments()->distinct('user_id')->get();
        $mailData = $comment->only('content');
        $mailData2 = $comment->user->only('name');
        foreach($postComments as $postComment){
            Mail::to($postComment->user->email)->send(new CreateCommentMail($mailData, $mailData2));
        }
        $postId = $comment->post->id;
        return redirect("/posts/$postId")->with('status', 'Comment successfully created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
