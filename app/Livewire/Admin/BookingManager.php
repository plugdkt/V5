<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RoomBooking;
use Illuminate\Support\Facades\Auth;

class BookingManager extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = ''; // pending, approved, rejected, cancelled
    public $selectedBookingId = null;
    public $rejectReason = '';
    public $isRejectModalOpen = false;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function approveBooking($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $booking->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        session()->flash('message', 'อนุมัติคำขอจองห้องประชุมสำเร็จ');
    }

    public function openRejectModal($id)
    {
        $this->selectedBookingId = $id;
        $this->rejectReason = '';
        $this->isRejectModalOpen = true;
    }

    public function closeRejectModal()
    {
        $this->isRejectModalOpen = false;
        $this->selectedBookingId = null;
    }

    public function rejectBooking()
    {
        $this->validate([
            'rejectReason' => 'required|string|max:255',
        ]);

        $booking = RoomBooking::findOrFail($this->selectedBookingId);
        $booking->update([
            'status' => 'rejected',
            'note' => $this->rejectReason,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        $this->closeRejectModal();
        session()->flash('message', 'ปฏิเสธคำขอจองห้องประชุมสำเร็จ');
    }

    public function render()
    {
        $bookings = RoomBooking::with(['room', 'user'])
            ->when($this->search, function($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->filterStatus, function($query) {
                $query->where('status', $this->filterStatus);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.booking-manager', [
            'bookings' => $bookings
        ]);
    }
}
