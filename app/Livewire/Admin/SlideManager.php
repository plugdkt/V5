<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Slide;

class SlideManager extends Component
{
    use WithPagination;

    public $search = '';
    public $isFormOpen = false;
    public $slideId = null;

    // Form fields
    public $eyebrow = '';
    public $title_th = '';
    public $title_highlight = '';
    public $title_th_end = '';
    public $subtitle = '';
    public $photo_path = '';
    public $primary_btn_text = 'ดูหลักสูตรทั้งหมด';
    public $primary_btn_url = '/programs';
    public $secondary_btn_text = 'แนะนำคณะ ▶';
    public $secondary_btn_url = '/about';
    public $order_key = 0;
    public $published = true;

    protected $rules = [
        'eyebrow' => 'nullable|string|max:255',
        'title_th' => 'required|string|max:255',
        'title_highlight' => 'nullable|string|max:255',
        'title_th_end' => 'nullable|string|max:255',
        'subtitle' => 'nullable|string',
        'photo_path' => 'required|string|max:255',
        'primary_btn_text' => 'nullable|string|max:255',
        'primary_btn_url' => 'nullable|string|max:255',
        'secondary_btn_text' => 'nullable|string|max:255',
        'secondary_btn_url' => 'nullable|string|max:255',
        'order_key' => 'required|integer',
        'published' => 'required|boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->slideId = $id;

        if ($id) {
            $slide = Slide::findOrFail($id);
            $this->eyebrow = $slide->eyebrow;
            $this->title_th = $slide->title_th;
            $this->title_highlight = $slide->title_highlight;
            $this->title_th_end = $slide->title_th_end;
            $this->subtitle = $slide->subtitle;
            $this->photo_path = $slide->photo_path;
            $this->primary_btn_text = $slide->primary_btn_text;
            $this->primary_btn_url = $slide->primary_btn_url;
            $this->secondary_btn_text = $slide->secondary_btn_text;
            $this->secondary_btn_url = $slide->secondary_btn_url;
            $this->order_key = $slide->order_key;
            $this->published = $slide->published;
        } else {
            $this->eyebrow = '';
            $this->title_th = '';
            $this->title_highlight = '';
            $this->title_th_end = '';
            $this->subtitle = '';
            $this->photo_path = '';
            $this->primary_btn_text = 'ดูหลักสูตรทั้งหมด';
            $this->primary_btn_url = '/programs';
            $this->secondary_btn_text = 'แนะนำคณะ ▶';
            $this->secondary_btn_url = '/about';
            $this->order_key = Slide::max('order_key') + 1;
            $this->published = true;
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->slideId = null;
    }

    public function saveSlide()
    {
        $this->validate();

        $data = [
            'eyebrow' => $this->eyebrow,
            'title_th' => $this->title_th,
            'title_highlight' => $this->title_highlight,
            'title_th_end' => $this->title_th_end,
            'subtitle' => $this->subtitle,
            'photo_path' => $this->photo_path,
            'primary_btn_text' => $this->primary_btn_text,
            'primary_btn_url' => $this->primary_btn_url,
            'secondary_btn_text' => $this->secondary_btn_text,
            'secondary_btn_url' => $this->secondary_btn_url,
            'order_key' => $this->order_key,
            'published' => $this->published,
        ];

        if ($this->slideId) {
            $slide = Slide::findOrFail($this->slideId);
            $slide->update($data);
            session()->flash('message', 'อัปเดตสไลด์โชว์สำเร็จแล้ว');
        } else {
            Slide::create($data);
            session()->flash('message', 'เพิ่มสไลด์โชว์ใหม่สำเร็จแล้ว');
        }

        $this->closeForm();
    }

    public function deleteSlide($id)
    {
        $slide = Slide::findOrFail($id);
        $slide->delete();
        session()->flash('message', 'ลบสไลด์โชว์เรียบร้อยแล้ว');
    }

    public function render()
    {
        $slidesList = Slide::where('title_th', 'like', '%' . $this->search . '%')
            ->orderBy('order_key', 'asc')
            ->paginate(10);

        return view('livewire.admin.slide-manager', [
            'slidesList' => $slidesList
        ]);
    }
}
