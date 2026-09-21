<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = $request->query('category');
        $tagSlug = $request->query('tag');
        
        $category = null;
        if ($categorySlug) {
            $category = NewsCategory::where('slug', $categorySlug)->first();
        }

        return view('public.news.index', compact('category', 'categorySlug', 'tagSlug'));
    }

    public function show($slug)
    {
        $article = News::where('slug', $slug)->with(['category', 'author', 'tags'])->firstOrFail();
        
        // Increment view count securely
        $article->increment('view_count');

        // Fetch related news in same category
        $relatedNews = News::published()
            ->where('category_id', $article->category_id)
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('public.news.show', compact('article', 'relatedNews'));
    }
}
