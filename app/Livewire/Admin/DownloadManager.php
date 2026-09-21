<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\DownloadableFile;
use App\Models\FileCategory;
use Illuminate\Support\Facades\Storage;

class DownloadManager extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $activeTab = 'files'; // files or categories
    public $search = '';
    public $selectedCategory = '';

    // File Form Fields
    public $isFileFormOpen = false;
    public $fileId = null;
    public $fileTitle = '';
    public $fileDescription = '';
    public $fileCategoryId = '';
    public $fileActive = true;
    public $fileUpload; // uploaded file temporary instance

    // Category Form Fields
    public $isCatFormOpen = false;
    public $catId = null;
    public $catName = '';
    public $catParentId = '';
    public $catIcon = '';
    public $catOrder = 0;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->closeFileForm();
        $this->closeCatForm();
    }

    // --- File CRUD ---

    public function openFileForm($id = null)
    {
        $this->resetValidation();
        $this->closeCatForm();
        $this->fileId = $id;

        if ($id) {
            $file = DownloadableFile::findOrFail($id);
            $this->fileTitle = $file->title;
            $this->fileDescription = $file->description;
            $this->fileCategoryId = $file->category_id;
            $this->fileActive = $file->active;
        } else {
            $this->fileTitle = '';
            $this->fileDescription = '';
            $this->fileCategoryId = FileCategory::orderBy('order')->first()?->id ?? '';
            $this->fileActive = true;
        }

        $this->fileUpload = null;
        $this->isFileFormOpen = true;
    }

    public function closeFileForm()
    {
        $this->isFileFormOpen = false;
        $this->fileId = null;
        $this->fileUpload = null;
    }

    public function saveFile()
    {
        $rules = [
            'fileTitle' => 'required|string|max:255',
            'fileDescription' => 'nullable|string|max:1000',
            'fileCategoryId' => 'required|exists:file_categories,id',
            'fileActive' => 'required|boolean',
        ];

        // File is required only for new uploads
        if (!$this->fileId) {
            $rules['fileUpload'] = 'required|file|max:20480'; // Max 20MB
        } else {
            $rules['fileUpload'] = 'nullable|file|max:20480';
        }

        $this->validate($rules);

        $data = [
            'title' => $this->fileTitle,
            'description' => $this->fileDescription,
            'category_id' => $this->fileCategoryId,
            'active' => $this->fileActive,
        ];

        if ($this->fileUpload) {
            // Save file to storage/app/public/downloads
            $storedPath = $this->fileUpload->store('public/downloads');
            $filename = basename($storedPath);

            $data['filename'] = $filename;
            $data['original_name'] = $this->fileUpload->getClientOriginalName();
            $data['mime_type'] = $this->fileUpload->getMimeType();
            $data['size'] = $this->fileUpload->getSize();

            // Delete old file if updating
            if ($this->fileId) {
                $oldFile = DownloadableFile::findOrFail($this->fileId);
                if ($oldFile->filename) {
                    Storage::delete('public/downloads/' . $oldFile->filename);
                }
            }
        }

        if ($this->fileId) {
            $file = DownloadableFile::findOrFail($this->fileId);
            $file->update($data);
            session()->flash('message', 'อัปเดตไฟล์แบบฟอร์มสำเร็จแล้ว');
        } else {
            $data['download_count'] = 0;
            $data['uploaded_by'] = auth()->id();
            DownloadableFile::create($data);
            session()->flash('message', 'อัปโหลดไฟล์แบบฟอร์มสำเร็จแล้ว');
        }

        $this->closeFileForm();
    }

    public function deleteFile($id)
    {
        $file = DownloadableFile::findOrFail($id);
        
        // Delete actual file from storage
        if ($file->filename) {
            Storage::delete('public/downloads/' . $file->filename);
        }

        $file->delete();
        session()->flash('message', 'ลบไฟล์ดาวน์โหลดเรียบร้อยแล้ว');
    }

    // --- Category CRUD ---

    public function openCatForm($id = null)
    {
        $this->resetValidation();
        $this->closeFileForm();
        $this->catId = $id;

        if ($id) {
            $cat = FileCategory::findOrFail($id);
            $this->catName = $cat->name;
            $this->catParentId = $cat->parent_id ?? '';
            $this->catIcon = $cat->icon;
            $this->catOrder = $cat->order;
        } else {
            $this->catName = '';
            $this->catParentId = '';
            $this->catIcon = '📁';
            $this->catOrder = FileCategory::max('order') + 1;
        }

        $this->isCatFormOpen = true;
    }

    public function closeCatForm()
    {
        $this->isCatFormOpen = false;
        $this->catId = null;
    }

    public function saveCategory()
    {
        $rules = [
            'catName' => 'required|string|max:255',
            'catParentId' => 'nullable|exists:file_categories,id',
            'catIcon' => 'nullable|string|max:50',
            'catOrder' => 'required|integer',
        ];

        // Prevent setting parent to itself
        if ($this->catId) {
            $rules['catParentId'] .= '|different:catId';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->catName,
            'parent_id' => $this->catParentId ?: null,
            'icon' => $this->catIcon ?: '📁',
            'order' => $this->catOrder,
        ];

        if ($this->catId) {
            $cat = FileCategory::findOrFail($this->catId);
            $cat->update($data);
            session()->flash('message', 'อัปเดตหมวดหมู่เอกสารสำเร็จแล้ว');
        } else {
            FileCategory::create($data);
            session()->flash('message', 'สร้างหมวดหมู่เอกสารสำเร็จแล้ว');
        }

        $this->closeCatForm();
    }

    public function deleteCategory($id)
    {
        $cat = FileCategory::findOrFail($id);

        // Delete associated files from storage too (cascade onDelete in database, but let's clear storage)
        foreach ($cat->files as $file) {
            if ($file->filename) {
                Storage::delete('public/downloads/' . $file->filename);
            }
        }

        $cat->delete();
        session()->flash('message', 'ลบหมวดหมู่และไฟล์ภายในเรียบร้อยแล้ว');
    }

    public function render()
    {
        // Files query
        $filesQuery = DownloadableFile::with('category')
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('original_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategory, function($q) {
                $q->where('category_id', $this->selectedCategory);
            })
            ->orderBy('id', 'desc');

        $filesList = $filesQuery->paginate(10, ['*'], 'filesPage');

        // Categories query
        $categoriesList = FileCategory::with('parent')
            ->orderBy('order')
            ->paginate(10, ['*'], 'categoriesPage');

        $allCategories = FileCategory::orderBy('order')->get();

        return view('livewire.admin.download-manager', [
            'filesList' => $filesList,
            'categoriesList' => $categoriesList,
            'allCategories' => $allCategories,
        ]);
    }
}
