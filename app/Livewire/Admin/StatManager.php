<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ServiceType;
use App\Models\ServiceStat;
use Illuminate\Support\Facades\Auth;

class StatManager extends Component
{
    public $service_type_id;
    public $period_year;
    public $period_month;
    public $value = 0;
    public $note = '';

    public $successMessage = '';

    public function mount()
    {
        $this->period_year = date('Y');
        $this->period_month = date('n');
        
        $types = ServiceType::where('active', true)->get();
        if ($types->isNotEmpty()) {
            $this->service_type_id = $types->first()->id;
        }
    }

    public function saveStat()
    {
        $this->validate([
            'service_type_id' => 'required|exists:service_types,id',
            'period_year' => 'required|integer|min:2000|max:2100',
            'period_month' => 'required|integer|min:1|max:12',
            'value' => 'required|numeric|min:0',
            'note' => 'nullable|string',
        ]);

        ServiceStat::updateOrCreate(
            [
                'service_type_id' => $this->service_type_id,
                'period_year' => $this->period_year,
                'period_month' => $this->period_month,
            ],
            [
                'value' => $this->value,
                'reported_by' => Auth::id(),
                'note' => $this->note,
            ]
        );

        $this->successMessage = 'บันทึกข้อมูลสถิติการให้บริการสำเร็จ!';
        $this->value = 0;
        $this->note = '';
    }

    public function render()
    {
        $stats = ServiceStat::with(['serviceType', 'reporter'])
            ->orderBy('period_year', 'desc')
            ->orderBy('period_month', 'desc')
            ->limit(10)
            ->get();

        $types = ServiceType::where('active', true)->get();

        return view('livewire.admin.stat-manager', [
            'stats' => $stats,
            'types' => $types
        ]);
    }
}
