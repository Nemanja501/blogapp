<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Mail\CreateCommentMail;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function showUpdateComment(string $id){
        $comment = Comment::find($id);
        return view('pages.updatecomment', compact('comment'));
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
    public function update(UpdateCommentRequest $request, string $id)
    {
        $comment = Comment::find($id);
        $postId = $comment->post->id;
        if(!Auth::user()->id == $comment->user->id){
            return redirect("/posts/$postId")->withErrors('Cannot update this comment!');
        }
        $comment->update($request->all());
        return redirect("/posts/$postId")->with('status', 'Updated comment!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        $postId = $comment->post->id;
        if(!Auth::user()->id == $comment->user->id){
            return redirect("/posts/$postId")->withErrors('Cannot delete this comment!');
        }
        $comment->delete();
        return redirect("/posts/$postId")->with('status', 'Comment deleted!');
    }
}
