<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use App\Events\PostCreated;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy("created_at", "desc")->paginate(10);
        $postsId = $posts->pluck('id')->toArray();
        $comment = Comment::where('commentable_type', 'App\Post')->whereIn('commentable_id', $postsId)->get();
        return view("home", compact("posts", "comment"));
    }

    public function create($userId)
    {
        $user = User::with('posts')->findOrFail($userId);
        return view('posts.create', compact('user'));
    }

    public function store(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
    
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'scheduled_at' => 'nullable|date|after:now',
        ], [
            'title.required' => 'Необходимо указать название поста',
            'content.required' => 'Необходимо указать контент',
            'scheduled_at.date' => 'Дата публикации должна быть корректной',
            'scheduled_at.after' => 'Дата публикации должна быть в будущем',
        ]);
    
        $post = new Post([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'scheduled_at' => $request->input('scheduled_at'),
        ]);
    
        $user->posts()->save($post);
        event(new PostCreated($post));
    
        return redirect('/users/' . $userId)->with('success', 'Пост успешно создан');
    }
        public function show($userId, $postId)
    {
        $user = User::findOrFail($userId);
        $post = Post::with('user')->findOrfail($postId);
        // return 1;
        return view("posts.show", compact("post"));
    }
    public function edit($userId, $postId)
    {
        $user = User::findOrFail($userId);
        $post = Post::with('user')->findOrfail($postId);
        return view('posts.edit', compact('post'));
    }

    public function update($userId, $postId, Request $request)
    {
        $post = Post::findOrFail($postId);

        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $post->update($validatedData);
        // return $post;
        return redirect('/users/' . $userId)->with('success', 'Пост успешно обновлен');
        // return back()->with('success', 'Пост успешно обновлен');
    }

    public function destroy($userId, $postId)
    {
        $post = Post::findOrFail($postId);
        $post->delete();
        return redirect('/users/' . $userId)->with('message', 'Элемент удален!');
    }

    public function publish($userId, $postId)
    {
        $post = Post::findOrFail($postId);
        $post->is_published = true;
        $post->publish_at = now();
        $post->save();
        return redirect('/users/' . $userId)->with('success', 'Пост успешно опубликован');
    }

    public function unpublish($userId, $postId)
    {
        $post = Post::findOrFail($postId);
        $post->is_published = false;
        $post->save();
        return redirect('/users/' . $userId)->with('success', 'Пост снят с публикации');
    }

    public function get_json()
    {
        return PostResource::collection(Post::all());
    }
}