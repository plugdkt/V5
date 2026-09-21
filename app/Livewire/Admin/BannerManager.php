<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Banner;

class BannerManager extends Component
{
    use WithPagination;

    public $search = '';
    public $isFormOpen = false;
    public $bannerId = null;

    // Form fields
    public $title = '';
    public $image = '';
    public $link = '#';
    public $order = 0;
    public $active = true;

    protected $rules = [
        'title' => 'nullable|string|max:255',
        'image' => 'required|string|max:255',
        'link' => 'nullable|string|max:255',
        'order' => 'required|integer',
        'active' => 'required|boolean',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->bannerId = $id;

        if ($id) {
            $banner = Banner::findOrFail($id);
            $this->title = $banner->title;
            $this->image = $banner->image;
            $this->link = $banner->link;
            $this->order = $banner->order;
            $this->active = $banner->active;
        } else {
            $this->title = '';
            $this->image = '';
            $this->link = '#';
            $this->order = Banner::max('order') + 1;
            $this->active = true;
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->bannerId = null;
    }

    public function saveBanner()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'image' => $this->image,
            'link' => $this->link ?? '#',
            'order' => $this->order,
            'active' => $this->active,
        ];

        if ($this->bannerId) {
            $banner = Banner::findOrFail($this->bannerId);
            $banner->update($data);
            session()->flash('message', 'อัปเดตแบนเนอร์ประชาสัมพันธ์สำเร็จแล้ว');
        } else {
            Banner::create($data);
            session()->flash('message', 'เพิ่มแบนเนอร์ประชาสัมพันธ์ใหม่สำเร็จแล้ว');
        }

        $this->closeForm();
    }

    public function deleteBanner($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        session()->flash('message', 'ลบแบนเนอร์ประชาสัมพันธ์เรียบร้อยแล้ว');
    }

    public function render()
    {
        $bannersList = Banner::query()
            ->when($this->search, function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('image', 'like', '%' . $this->search . '%');
            })
            ->orderBy('order', 'asc')
            ->paginate(10);

        return view('livewire.admin.banner-manager', [
            'bannersList' => $bannersList
        ]);
    }
}
