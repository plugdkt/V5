<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AcademicArticle;

class AcademicArticleManager extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = 'all';
    public $isFormOpen = false;
    public $articleId = null;

    // Form fields
    public $title = '';
    public $author = '';
    public $division = '';
    public $category = 'other';
    public $link_url = '';
    public $abstract = '';
    public $published_at = '';
    public $is_active = true;
    public $sort_order = 0;

    protected $rules = [
        'title' => 'required|string|max:500',
        'author' => 'nullable|string|max:255',
        'division' => 'nullable|string|max:255',
        'category' => 'required|string',
        'link_url' => 'nullable|url|max:500',
        'abstract' => 'nullable|string',
        'published_at' => 'nullable|date',
        'is_active' => 'required|boolean',
        'sort_order' => 'required|integer',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->articleId = $id;

        if ($id) {
            $article = AcademicArticle::findOrFail($id);
            $this->title = $article->title;
            $this->author = $article->author;
            $this->division = $article->division;
            $this->category = $article->category;
            $this->link_url = $article->link_url;
            $this->abstract = $article->abstract;
            $this->published_at = $article->published_at ? $article->published_at->format('Y-m-d') : '';
            $this->is_active = $article->is_active;
            $this->sort_order = $article->sort_order;
        } else {
            $this->title = '';
            $this->author = '';
            $this->division = '';
            $this->category = 'other';
            $this->link_url = '';
            $this->abstract = '';
            $this->published_at = date('Y-m-d');
            $this->is_active = true;
            $this->sort_order = AcademicArticle::count() + 1;
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
            'title' => $this->title,
            'author' => $this->author,
            'division' => $this->division,
            'category' => $this->category,
            'link_url' => $this->link_url,
            'abstract' => $this->abstract,
            'published_at' => $this->published_at ?: null,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->articleId) {
            $article = AcademicArticle::findOrFail($this->articleId);
            $article->update($data);
            session()->flash('message', 'อัปเดตบทความวิชาการเรียบร้อยแล้ว');
        } else {
            AcademicArticle::create($data);
            session()->flash('message', 'เพิ่มบทความวิชาการใหม่เรียบร้อยแล้ว');
        }

        $this->closeForm();
    }

    public function deleteArticle($id)
    {
        $article = AcademicArticle::findOrFail($id);
        $article->delete();
        session()->flash('message', 'ลบบทความวิชาการเรียบร้อยแล้ว');
    }

    public function render()
    {
        $articles = AcademicArticle::when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('author', 'like', '%' . $this->search . '%')
                  ->orWhere('division', 'like', '%' . $this->search . '%');
            })
            ->when($this->categoryFilter !== 'all', function ($q) {
                $q->where('category', $this->categoryFilter);
            })
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(15);

        return view('livewire.admin.academic-article-manager', [
            'articles' => $articles
        ]);
    }
}
