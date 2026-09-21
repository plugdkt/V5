<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;

class EventCalendar extends Component
{
    public $currentYear;
    public $currentMonth;
    public $selectedDate;
    public $events = [];

    public function mount()
    {
        $now = Carbon::now();
        $this->currentYear = $now->year;
        $this->currentMonth = $now->month;
        $this->selectedDate = $now->toDateString();
        $this->loadEvents();
    }

    public function selectDate($dateString)
    {
        $this->selectedDate = $dateString;
        $this->loadEvents();
    }

    public function prevMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
    }

    public function nextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentYear = $date->year;
        $this->currentMonth = $date->month;
    }

    private function loadEvents()
    {
        $this->events = Event::whereDate('start_date', '<=', $this->selectedDate)
            ->whereDate('end_date', '>=', $this->selectedDate)
            ->with('category')
            ->orderBy('start_date')
            ->get();
    }

    public function render()
    {
        // Calculate days in month
        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1);
        $daysInMonth = $startOfMonth->daysInMonth;
        $dayOfWeekOffset = $startOfMonth->dayOfWeek; // 0 = Sunday, 1 = Monday etc.

        // Get days with events for the current month
        $monthStart = $startOfMonth->toDateString();
        $monthEnd = $startOfMonth->copy()->endOfMonth()->toDateString();
        
        $daysWithEvents = Event::where(function($query) use ($monthStart, $monthEnd) {
                $query->whereBetween('start_date', [$monthStart, $monthEnd])
                      ->orWhereBetween('end_date', [$monthStart, $monthEnd])
                      ->orWhere(function($q) use ($monthStart, $monthEnd) {
                          $q->where('start_date', '<=', $monthStart)
                            ->where('end_date', '>=', $monthEnd);
                      });
            })
            ->get()
            ->flatMap(function($event) {
                $period = new \DatePeriod(
                    new \DateTime(Carbon::parse($event->start_date)->toDateString()),
                    new \DateInterval('P1D'),
                    new \DateTime(Carbon::parse($event->end_date)->addDay()->toDateString())
                );
                $days = [];
                foreach ($period as $date) {
                    $days[] = $date->format('Y-m-d');
                }
                return $days;
            })
            ->unique()
            ->toArray();

        return view('livewire.public.event-calendar', [
            'daysInMonth' => $daysInMonth,
            'dayOfWeekOffset' => $dayOfWeekOffset,
            'daysWithEvents' => $daysWithEvents,
            'monthName' => $startOfMonth->locale('th')->translatedFormat('F Y'),
        ]);
    }
}
