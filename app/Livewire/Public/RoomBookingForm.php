<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\MeetingRoom;
use App\Models\RoomBooking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class RoomBookingForm extends Component
{
    public $selectedRoomId = '';
    public $selectedDate;
    public $bookings = [];
    public $rooms = [];

    // Form fields
    public $title = '';
    public $purpose = '';
    public $attendees = 10;
    public $start_time = '09:00';
    public $end_time = '12:00';
    
    public $successMessage = '';
    public $errorMessage = '';

    public function mount()
    {
        $this->rooms = MeetingRoom::where('active', true)->get();
        if ($this->rooms->isNotEmpty()) {
            $this->selectedRoomId = $this->rooms->first()->id;
        }
        $this->selectedDate = date('Y-m-d');
        $this->loadBookings();
    }

    public function updatedSelectedRoomId()
    {
        $this->loadBookings();
        $this->resetForm();
    }

    public function updatedSelectedDate()
    {
        $this->loadBookings();
    }

    public function loadBookings()
    {
        if (empty($this->selectedRoomId)) {
            $this->bookings = [];
            return;
        }

        $this->bookings = RoomBooking::where('room_id', $this->selectedRoomId)
            ->whereDate('start_datetime', $this->selectedDate)
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('start_datetime')
            ->get();
    }

    public function resetForm()
    {
        $this->title = '';
        $this->purpose = '';
        $this->attendees = 10;
        $this->start_time = '09:00';
        $this->end_time = '12:00';
        $this->successMessage = '';
        $this->errorMessage = '';
    }

    public function submitBooking()
    {
        if (!Auth::check()) {
            $this->errorMessage = 'กรุณาเข้าสู่ระบบก่อนทำการจองห้องประชุม';
            return;
        }

        $this->validate([
            'selectedRoomId' => 'required|exists:meeting_rooms,id',
            'selectedDate' => 'required|date|after_or_equal:today',
            'title' => 'required|string|max:255',
            'purpose' => 'nullable|string',
            'attendees' => 'required|integer|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $start = Carbon::parse($this->selectedDate . ' ' . $this->start_time);
        $end = Carbon::parse($this->selectedDate . ' ' . $this->end_time);

        // Check conflict
        $conflict = RoomBooking::where('room_id', $this->selectedRoomId)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function($query) use ($start, $end) {
                $query->where(function($q) use ($start, $end) {
                    $q->where('start_datetime', '<', $end)
                      ->where('end_datetime', '>', $start);
                });
            })
            ->exists();

        if ($conflict) {
            $this->errorMessage = 'ช่วงเวลาดังกล่าวมีการจองแล้ว กรุณาเลือกช่วงเวลาอื่น';
            return;
        }

        RoomBooking::create([
            'room_id' => $this->selectedRoomId,
            'user_id' => Auth::id(),
            'title' => $this->title,
            'purpose' => $this->purpose,
            'attendees' => $this->attendees,
            'start_datetime' => $start,
            'end_datetime' => $end,
            'status' => 'pending',
        ]);

        $this->successMessage = 'ส่งคำขอจองห้องประชุมสำเร็จ! กรุณารอเจ้าหน้าที่ตรวจสอบและอนุมัติ';
        $this->resetForm();
        $this->loadBookings();
    }

    public function render()
    {
        $currentRoom = MeetingRoom::find($this->selectedRoomId);

        return view('livewire.public.room-booking-form', [
            'currentRoom' => $currentRoom
        ]);
    }
}
