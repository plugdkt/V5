<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Asset;
use App\Models\AssetCategory;

class AssetManager extends Component
{
    public function render()
    {
        $assets = Asset::with('category')->latest()->get();
        return view('livewire.admin.asset-manager', [
            'assets' => $assets
        ]);
    }
}
