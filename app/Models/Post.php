<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    // Lista tutti i post
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return response()->json($posts);
    }

    // Crea un nuovo post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:255',
            'content'  => 'required|string',
            'image'    => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'status'   => 'in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['user_id'] = auth()->id();

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        return response()->json($post, 201);
    }

    // Mostra un singolo post
    public function show(Post $post)
    {
        return response()->json($post);
    }

    // Aggiorna un post
    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'    => 'sometimes|string|max:255',
            'content'  => 'sometimes|string',
            'image'    => 'nullable|string',
            'category' => 'nullable|string|max:100',
            'status'   => 'in:draft,published',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (isset($validated['status']) && $validated['status'] === 'published' && !$post->published_at) {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return response()->json($post);
    }

    // Elimina un post
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(['message' => 'Post eliminato con successo']);
    }
}