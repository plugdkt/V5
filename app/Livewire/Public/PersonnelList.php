<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Personnel;
use App\Models\Department;

class PersonnelList extends Component
{
    public $search = '';
    public $selectedDepartmentId = '';

    public function selectDepartment($id)
    {
        $this->selectedDepartmentId = $id;
    }

    public function render()
    {
        $departments = Department::orderBy('order')->get();

        $personnel = Personnel::where('status', true)
            ->with(['position', 'department'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->where('firstname_th', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname_th', 'like', '%' . $this->search . '%')
                      ->orWhere('firstname_en', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname_en', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedDepartmentId, function($query) {
                $query->where('department_id', $this->selectedDepartmentId);
            })
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        return view('livewire.public.personnel-list', [
            'personnel' => $personnel,
            'departments' => $departments
        ]);
    }
}
