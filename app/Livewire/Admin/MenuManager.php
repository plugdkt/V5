<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\MenuItem;

class MenuManager extends Component
{
    public $locationFilter = 'header';
    public $isFormOpen = false;
    public $menuId = null;

    // Form fields
    public $title_th = '';
    public $title_en = '';
    public $url = '';
    public $parent_id = null;
    public $order = 0;
    public $target = '_self';
    public $location = 'header';
    public $active = true;

    // Page link helpers
    public $linkType = 'custom';
    public $selectedPage = '';

    protected $rules = [
        'title_th' => 'required|string|max:255',
        'title_en' => 'nullable|string|max:255',
        'url' => 'required|string|max:255',
        'parent_id' => 'nullable|exists:menu_items,id',
        'order' => 'required|integer',
        'target' => 'required|in:_self,_blank',
        'location' => 'required|string',
        'active' => 'required|boolean',
    ];

    public function updatedSelectedPage($value)
    {
        if ($this->linkType === 'page') {
            $this->url = $value;
        }
    }

    public function updatedLinkType($value)
    {
        if ($value === 'page') {
            $this->url = $this->selectedPage;
        }
    }

    public function updatedLocationFilter($value)
    {
        $this->location = $value;
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->menuId = $id;

        if ($id) {
            $item = MenuItem::findOrFail($id);
            $this->title_th = $item->title_th;
            $this->title_en = $item->title_en;
            $this->url = $item->url;
            $this->parent_id = $item->parent_id;
            $this->order = $item->order;
            $this->target = $item->target;
            $this->location = $item->location;
            $this->active = $item->active;

            // Resolve if URL is a page link
            $systemUrls = [
                '/', '/about', '/about/structure', '/about/management', '/about/vision',
                '/programs', '/research', '/services', '/calendar', '/contact'
            ];
            if (in_array($item->url, $systemUrls) || str_starts_with($item->url, '/pages/')) {
                $this->linkType = 'page';
                $this->selectedPage = $item->url;
            } else {
                $this->linkType = 'custom';
                $this->selectedPage = '';
            }
        } else {
            $this->title_th = '';
            $this->title_en = '';
            $this->url = '';
            $this->parent_id = null;
            $this->order = MenuItem::where('location', $this->locationFilter)->count() + 1;
            $this->target = '_self';
            $this->location = $this->locationFilter;
            $this->active = true;
            $this->linkType = 'custom';
            $this->selectedPage = '';
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->menuId = null;
    }

    public function saveMenu()
    {
        $this->validate();

        $data = [
            'title_th' => $this->title_th,
            'title_en' => $this->title_en,
            'url' => $this->url,
            'parent_id' => $this->parent_id ?: null,
            'order' => $this->order,
            'target' => $this->target,
            'location' => $this->location,
            'active' => $this->active,
        ];

        if ($this->menuId) {
            $item = MenuItem::findOrFail($this->menuId);
            $item->update($data);
            session()->flash('message', 'อัปเดตข้อมูลเมนูเรียบร้อยแล้ว');
        } else {
            MenuItem::create($data);
            session()->flash('message', 'เพิ่มเมนูใหม่เรียบร้อยแล้ว');
        }

        $this->closeForm();
    }

    public function deleteMenu($id)
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();
        session()->flash('message', 'ลบเมนูเรียบร้อยแล้ว');
    }

    public function render()
    {
        // Fetch all top-level items with nested children (Level 1 -> 2 -> 3)
        $menus = MenuItem::where('location', $this->locationFilter)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->with('allChildren.allChildren')
            ->get();

        // Fetch parent candidates (Level 1 and Level 2 items)
        $parentCandidates = MenuItem::where('location', 'header')
            ->whereNull('parent_id')
            ->with(['allChildren' => function ($query) {
                $query->orderBy('order');
            }])
            ->when($this->menuId, function ($query) {
                $query->where('id', '!=', $this->menuId);
            })
            ->orderBy('order')
            ->get();


        // Fetch all dynamic pages
        $pages = \App\Models\Page::orderBy('title')->get();

        return view('livewire.admin.menu-manager', [
            'menus' => $menus,
            'parentCandidates' => $parentCandidates,
            'pages' => $pages
        ]);
    }
}
