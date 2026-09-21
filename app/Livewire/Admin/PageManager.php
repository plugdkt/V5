<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Page;
use Illuminate\Support\Str;

class PageManager extends Component
{
    use WithPagination;

    public $search = '';
    public $isFormOpen = false;
    public $pageId = null;

    // Form fields
    public $title = '';
    public $slug = '';
    public $body = '';
    public $pdf_path = '';
    public $meta_description = '';
    public $published = true;

    protected $rules = [
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'body' => 'nullable|string',
        'pdf_path' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:255',
        'published' => 'required|boolean',
    ];


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->pageId = $id;

        if ($id) {
            $page = Page::findOrFail($id);
            $this->title = $page->title;
            $this->slug = $page->slug;
            $this->body = $page->body;
            $this->pdf_path = $page->pdf_path;
            $this->meta_description = $page->meta_description;
            $this->published = $page->published;
        } else {
            $this->title = '';
            $this->slug = '';
            $this->body = '';
            $this->pdf_path = '';
            $this->meta_description = '';
            $this->published = true;
        }


        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->pageId = null;
    }

    public function updatedTitle($value)
    {
        if (empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function savePage()
    {
        $this->validate();

        // Unique slug check except current editing page
        $slugCheck = Page::where('slug', $this->slug)
            ->when($this->pageId, function ($query) {
                $query->where('id', '!=', $this->pageId);
            })->exists();

        if ($slugCheck) {
            $this->addError('slug', 'URL Slug นี้ถูกใช้งานแล้ว กรุณาระบุชื่ออื่น');
            return;
        }

        $data = [
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'pdf_path' => $this->pdf_path,
            'meta_description' => $this->meta_description,
            'published' => $this->published,
        ];


        if ($this->pageId) {
            $page = Page::findOrFail($this->pageId);
            $page->update($data);
            session()->flash('message', 'อัปเดตข้อมูลหน้าเพจสำเร็จแล้ว');
        } else {
            Page::create($data);
            session()->flash('message', 'สร้างหน้าเพจใหม่สำเร็จแล้ว');
        }

        $this->closeForm();
    }

    public function deletePage($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        session()->flash('message', 'ลบหน้าเพจเรียบร้อยแล้ว');
    }

    public function render()
    {
        $pages = Page::where('title', 'like', '%' . $this->search . '%')
            ->orWhere('slug', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.page-manager', [
            'pagesList' => $pages
        ]);
    }
}
