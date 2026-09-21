<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\EService;

class EServiceManager extends Component
{
    use WithPagination;

    public $search = '';
    public $isFormOpen = false;
    public $serviceId = null;

    // Form fields
    public $title = '';
    public $description = '';
    public $url = '';
    public $manual_url = '';
    public $category = []; // Array of categories
    public $badge_text = '';
    public $is_active = true;
    public $sort_order = 0;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'url' => 'required|string|max:255',
        'manual_url' => 'nullable|string|max:255',
        'category' => 'required|array|min:1',
        'category.*' => 'string|in:student,staff,general',
        'badge_text' => 'nullable|string|max:255',
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
        $this->serviceId = $id;

        if ($id) {
            $service = EService::findOrFail($id);
            $this->title = $service->title;
            $this->description = $service->description;
            $this->url = $service->url;
            $this->manual_url = $service->manual_url;
            $this->category = $service->category ?? [];
            $this->badge_text = $service->badge_text;
            $this->is_active = $service->is_active;
            $this->sort_order = $service->sort_order;
        } else {
            $this->title = '';
            $this->description = '';
            $this->url = '';
            $this->manual_url = '';
            $this->category = ['student'];
            $this->badge_text = '';
            $this->is_active = true;
            $this->sort_order = (int) EService::max('sort_order') + 1;
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->serviceId = null;
    }

    public function saveService()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'manual_url' => $this->manual_url ?: null,
            'category' => $this->category,
            'badge_text' => $this->badge_text ?: null,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
        ];

        if ($this->serviceId) {
            $service = EService::findOrFail($this->serviceId);
            $service->update($data);
            session()->flash('message', 'อัปเดตบริการออนไลน์เรียบร้อยแล้ว');
        } else {
            EService::create($data);
            session()->flash('message', 'เพิ่มบริการออนไลน์ใหม่เรียบร้อยแล้ว');
        }

        $this->closeForm();
    }

    public function deleteService($id)
    {
        $service = EService::findOrFail($id);
        $service->delete();
        session()->flash('message', 'ลบบริการออนไลน์เรียบร้อยแล้ว');
    }

    public function render()
    {
        $services = EService::query()
            ->where(function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('sort_order')
            ->paginate(10);

        return view('livewire.admin.e-service-manager', [
            'services' => $services
        ]);
    }
}
