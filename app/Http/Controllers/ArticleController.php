<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['author', 'room'])->latest()->get();
        return view('pages.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $rooms = Room::all(); 
        return view('pages.articles.create', compact('rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'related_room_id' => 'nullable|exists:rooms,id',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Article::create([
            'author_id' => Auth::id(),
            'related_room_id' => $request->related_room_id,
            'title' => $request->title,
            'content' => $request->content,
            'thumbnail_url' => $path,
            'published_at' => now(),
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        if ($article->author_id !== Auth::id()) abort(403);
        $rooms = Room::all();
        return view('pages.articles.edit', compact('article', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        if ($article->author_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'related_room_id' => 'nullable|exists:rooms,id',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($article->thumbnail_url) {
                Storage::disk('public')->delete($article->thumbnail_url);
            }
            $article->thumbnail_url = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $article->update([
            'title' => $request->title,
            'content' => $request->content,
            'related_room_id' => $request->related_room_id,
        ]);

        return redirect()->route('articles.index')->with('success', 'Artikel diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        if ($article->author_id !== Auth::id()) abort(403);
        
        if ($article->thumbnail_url) {
            Storage::disk('public')->delete($article->thumbnail_url);
        }
        
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Artikel dihapus.');
    }
}
