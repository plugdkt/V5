<?php

namespace App\Livewire\Public;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;

class NewsGrid extends Component
{
    use WithPagination;

    public $search = '';
    public $categorySlug = '';
    public $tagSlug = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'categorySlug' => ['as' => 'category', 'except' => ''],
        'tagSlug' => ['as' => 'tag', 'except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectCategory($slug)
    {
        $this->categorySlug = $slug;
        $this->resetPage();
    }

    public function selectTag($slug)
    {
        $this->tagSlug = $slug;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->categorySlug = '';
        $this->tagSlug = '';
        $this->resetPage();
    }

    public function render()
    {
        $categories = NewsCategory::orderBy('order')->get();
        $popularTags = NewsTag::withCount('news')->orderBy('news_count', 'desc')->limit(10)->get();

        $news = News::published()
            ->with(['category', 'tags'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('title_th', 'like', '%' . $this->search . '%')
                      ->orWhere('body', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->categorySlug, function($query) {
                $query->whereHas('category', function($q) {
                    $q->where('slug', $this->categorySlug);
                });
            })
            ->when($this->tagSlug, function($query) {
                $query->whereHas('tags', function($q) {
                    $q->where('slug', $this->tagSlug);
                });
            })
            ->latest('published_at')
            ->paginate(9);

        return view('livewire.public.news-grid', [
            'news' => $news,
            'categories' => $categories,
            'popularTags' => $popularTags
        ]);
    }
}
