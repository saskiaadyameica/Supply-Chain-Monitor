<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::latest()->get();

        return view('admin.articles.index', compact('articles'));
    }

    public function create(Request $request)
    {
        $news = null;

        if ($request->has('import')) {

            $response = Http::withoutVerifying()->get(
                'https://gnews.io/api/v4/search',
                [
                    'q' => 'logistics',
                    'lang' => 'en',
                    'max' => 1,
                    'sortby' => 'publishedAt',
                    'apikey' => env('GNEWS_API_KEY'),
                ]
            );

            if ($response->successful()) {

                $articles = $response->json()['articles'] ?? [];

                if (!empty($articles)) {
                    $news = $articles[0];
                }
            }
        }

        return view('admin.articles.create', compact('news'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'content' => 'required',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('articles', 'public');
        }

        Article::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'category' => $request->category,
            'image' => $image,
            'content' => $request->content,
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article added successfully.');
    }

    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|max:255',
            'category' => 'required|max:100',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'content' => 'required',
        ]);

        $image = $article->image;

        if ($request->hasFile('image')) {

            if ($article->image) {
                Storage::disk('public')->delete($article->image);
            }

            $image = $request->file('image')->store('articles', 'public');
        }

        $article->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'category' => $request->category,
            'image' => $image,
            'content' => $request->content,
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }

        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Article deleted successfully.');
    }
}