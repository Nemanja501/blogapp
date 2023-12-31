<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Mail\CreatePostMail;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::paginate(3);
        return view('pages.posts', compact('posts'));
    }

    public function showUpdatePost(){
        $tags = Tag::all();
        return view('pages.updatepost', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePostRequest $request)
    {

        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => $request->user_id
        ]);

        $post->tags()->attach($request->tags);

        $userEmail = Auth::user()->email;
        $mailData = $post->only('title', 'body');
        Mail::to($userEmail)->send(new CreatePostMail($mailData));

        return redirect('createpost')->with('status', 'Post successfully created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::findOrFail($id);
        return view('pages.post', compact('post'));
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

    public function createPost()
    {
        $tags = Tag::all();
        return view('pages.createpost', compact('tags'));
    }
}
