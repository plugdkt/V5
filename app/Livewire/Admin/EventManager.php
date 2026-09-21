<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Event;
use App\Models\EventCategory;

class EventManager extends Component
{
    public function render()
    {
        $events = Event::with('category')->latest()->get();
        return view('livewire.admin.event-manager', [
            'events' => $events
        ]);
    }
}
