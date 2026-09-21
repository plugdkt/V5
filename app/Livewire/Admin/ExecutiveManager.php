<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Executive;

class ExecutiveManager extends Component
{
    use WithPagination;

    public $search = '';
    public $isFormOpen = false;
    public $executiveId = null;

    // Form fields
    public $name_th = '';
    public $name_en = '';
    public $position_th = '';
    public $position_en = '';
    public $email = '';
    public $phone = '';
    public $photo_path = '';
    public $duties = '';
    public $order_key = 0;

    protected $rules = [
        'name_th' => 'required|string|max:255',
        'name_en' => 'nullable|string|max:255',
        'position_th' => 'required|string|max:255',
        'position_en' => 'nullable|string|max:255',
        'email' => 'nullable|email|max:255',
        'phone' => 'nullable|string|max:255',
        'photo_path' => 'nullable|string|max:255',
        'duties' => 'nullable|string',
        'order_key' => 'required|integer',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->executiveId = $id;

        if ($id) {
            $exec = Executive::findOrFail($id);
            $this->name_th = $exec->name_th;
            $this->name_en = $exec->name_en;
            $this->position_th = $exec->position_th;
            $this->position_en = $exec->position_en;
            $this->email = $exec->email;
            $this->phone = $exec->phone;
            $this->photo_path = $exec->photo_path;
            $this->duties = $exec->duties;
            $this->order_key = $exec->order_key;
        } else {
            $this->name_th = '';
            $this->name_en = '';
            $this->position_th = '';
            $this->position_en = '';
            $this->email = '';
            $this->phone = '';
            $this->photo_path = '';
            $this->duties = '';
            $this->order_key = Executive::max('order_key') + 1;
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->executiveId = null;
    }

    public function saveExecutive()
    {
        $this->validate();

        $data = [
            'name_th' => $this->name_th,
            'name_en' => $this->name_en,
            'position_th' => $this->position_th,
            'position_en' => $this->position_en,
            'email' => $this->email,
            'phone' => $this->phone,
            'photo_path' => $this->photo_path,
            'duties' => $this->duties,
            'order_key' => $this->order_key,
        ];

        if ($this->executiveId) {
            $exec = Executive::findOrFail($this->executiveId);
            $exec->update($data);
            session()->flash('message', 'อัปเดตข้อมูลผู้บริหารสำเร็จแล้ว');
        } else {
            Executive::create($data);
            session()->flash('message', 'เพิ่มข้อมูลผู้บริหารใหม่สำเร็จแล้ว');
        }

        $this->closeForm();
    }

    public function deleteExecutive($id)
    {
        $exec = Executive::findOrFail($id);
        $exec->delete();
        session()->flash('message', 'ลบข้อมูลผู้บริหารเรียบร้อยแล้ว');
    }

    public function render()
    {
        $executives = Executive::where('name_th', 'like', '%' . $this->search . '%')
            ->orWhere('position_th', 'like', '%' . $this->search . '%')
            ->orderBy('order_key', 'asc')
            ->paginate(15);

        return view('livewire.admin.executive-manager', [
            'executivesList' => $executives
        ]);
    }
}
