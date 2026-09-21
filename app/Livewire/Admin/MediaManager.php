<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MediaManager extends Component
{
    use WithFileUploads, WithPagination;

    public $pickerMode = false;
    public $search = '';
    public $filterType = 'all'; // all, image, document

    // Upload files property
    public $fileUploads = [];

    protected $queryString = ['search', 'filterType'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function uploadFiles()
    {
        $this->validate([
            'fileUploads' => 'required|array|min:1',
            'fileUploads.*' => 'file|max:10240', // max 10MB
        ]);


        foreach ($this->fileUploads as $file) {
            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getMimeType();
            $size = $file->getSize();

            // Store file under public/media
            $path = $file->store('media', 'public');
            $fileName = basename($path);

            Media::create([
                'name' => $originalName,
                'file_name' => $fileName,
                'file_path' => 'media/' . $fileName,
                'mime_type' => $mimeType,
                'size' => $size,
                'uploaded_by' => Auth::id(),
            ]);
        }

        $this->fileUploads = [];
        session()->flash('message', 'อัปโหลดไฟล์สื่อเสร็จสมบูรณ์');
    }

    public function deleteFile($id)
    {
        $media = Media::findOrFail($id);
        
        // Delete from public disk storage
        if (Storage::disk('public')->exists($media->file_path)) {
            Storage::disk('public')->delete($media->file_path);
        }

        $media->delete();
        session()->flash('message', 'ลบไฟล์สื่อเรียบร้อยแล้ว');
    }

    public function render()
    {
        $mediaQuery = Media::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterType === 'image', function ($query) {
                $query->where('mime_type', 'like', 'image/%');
            })
            ->when($this->filterType === 'document', function ($query) {
                $query->where('mime_type', 'not like', 'image/%');
            });

        $mediaFiles = $mediaQuery->latest()->paginate(12);

        return view('livewire.admin.media-manager', [
            'files' => $mediaFiles
        ]);
    }
}
