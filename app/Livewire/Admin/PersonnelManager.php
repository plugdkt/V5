<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Personnel;
use App\Models\Department;

class PersonnelManager extends Component
{
    public function render()
    {
        $personnel = Personnel::with(['position', 'department'])->orderBy('order')->get();
        return view('livewire.admin.personnel-manager', [
            'personnel' => $personnel
        ]);
    }
}
