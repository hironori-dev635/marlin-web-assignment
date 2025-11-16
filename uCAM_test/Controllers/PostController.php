<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {  //dd(Post::all()->toArray());
        // Inertia で Vue に渡す
        return Inertia::render('Posts/IndexComp', [
            'posts' => Post::all()->toArray(),
        ]);
    }

    public function store(Request $request)
    {//dd($request);
        $request->validate(['name' => 'required|string|max:20']);
        Post::create(['name' => $request->name]);

        return redirect()->route('posts.index');
    }

public function update(Request $request, Post $post)
    {//dd($request);
        $request->validate(['name' => 'required|string|max:20']);
        $post->update(['name' => $request->name]);

        return redirect()->route('posts.index');
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index');
    }
}
