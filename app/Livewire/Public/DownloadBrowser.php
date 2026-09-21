<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\DownloadableFile;
use App\Models\FileCategory;

class DownloadBrowser extends Component
{
    public $search = '';
    public $selectedCategoryId = '';

    public function selectCategory($id)
    {
        $this->selectedCategoryId = $id;
    }

    public function incrementDownload($fileId)
    {
        $file = DownloadableFile::find($fileId);
        if ($file) {
            $file->increment('download_count');
            // Redirect will be handled in front-end using standard href pointing to a download route
        }
    }

    public function render()
    {
        $categories = FileCategory::withCount(['files' => function($q) {
            $q->where('active', true);
        }])->orderBy('order')->get();

        $files = DownloadableFile::where('active', true)
            ->with('category')
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedCategoryId, function($query) {
                $query->where('category_id', $this->selectedCategoryId);
            })
            ->latest()
            ->get();

        return view('livewire.public.download-browser', [
            'files' => $files,
            'categories' => $categories
        ]);
    }
}
