<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class NewsManager extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $isFormOpen = false;
    public $articleId = null;

    // Form properties
    public $category_id;
    public $title_th = '';
    public $title_en = '';
    public $excerpt = '';
    public $body = '';
    public $cover_image; // uploaded file
    public $existing_cover_image; // string path
    public $status = 'draft';
    public $published_at;

    protected $rules = [
        'category_id' => 'required|exists:news_categories,id',
        'title_th' => 'required|string|max:255',
        'title_en' => 'nullable|string|max:255',
        'excerpt' => 'nullable|string',
        'body' => 'required|string',
        'status' => 'required|in:draft,published',
        'cover_image' => 'nullable|image|max:2048', // max 2MB
    ];

    public function mount()
    {
        $this->published_at = date('Y-m-d H:i');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->articleId = $id;

        if ($id) {
            $article = News::findOrFail($id);
            $this->category_id = $article->category_id;
            $this->title_th = $article->title_th;
            $this->title_en = $article->title_en;
            $this->excerpt = $article->excerpt;
            $this->body = $article->body;
            $this->status = $article->status;
            $this->existing_cover_image = $article->cover_image;
            $this->published_at = $article->published_at ? $article->published_at->format('Y-m-d H:i') : date('Y-m-d H:i');
        } else {
            $categories = NewsCategory::orderBy('order')->get();
            $this->category_id = $categories->isNotEmpty() ? $categories->first()->id : null;
            $this->title_th = '';
            $this->title_en = '';
            $this->excerpt = '';
            $this->body = '';
            $this->status = 'draft';
            $this->cover_image = null;
            $this->existing_cover_image = null;
            $this->published_at = date('Y-m-d H:i');
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->articleId = null;
    }

    public function saveArticle()
    {
        $this->validate();

        $data = [
            'category_id' => $this->category_id,
            'title_th' => $this->title_th,
            'title_en' => $this->title_en,
            'excerpt' => $this->excerpt ?: Str::words(strip_tags($this->body), 20),
            'body' => $this->body,
            'status' => $this->status,
            'published_at' => $this->status === 'published' ? $this->published_at : null,
        ];

        if ($this->cover_image) {
            // Delete old cover image if editing
            if ($this->existing_cover_image) {
                Storage::disk('public')->delete($this->existing_cover_image);
            }
            $imagePath = $this->cover_image->store('news', 'public');
            $data['cover_image'] = $imagePath;
        }

        if ($this->articleId) {
            $article = News::findOrFail($this->articleId);
            $article->update($data);
            session()->flash('message', 'อัปเดตข่าวสารประชาสัมพันธ์สำเร็จ');
        } else {
            $slug = Str::slug($this->title_th);
            if (empty($slug)) {
                $slug = 'news-' . rand(1000, 9999);
            }
            $originalSlug = $slug;
            $i = 1;
            while (News::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }

            $data['slug'] = $slug;
            $data['author_id'] = Auth::id();
            News::create($data);
            session()->flash('message', 'สร้างข่าวสารประชาสัมพันธ์สำเร็จ');
        }

        $this->closeForm();
    }

    public function deleteArticle($id)
    {
        $article = News::findOrFail($id);
        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }
        $article->delete();
        session()->flash('message', 'ลบข่าวประชาสัมพันธ์สำเร็จ');
    }

    public function render()
    {
        $news = News::with('category')
            ->where('title_th', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        $categories = NewsCategory::orderBy('order')->get();

        return view('livewire.admin.news-manager', [
            'articles' => $news,
            'categories' => $categories
        ]);
    }
}
