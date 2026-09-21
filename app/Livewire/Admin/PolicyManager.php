<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PolicyCategory;
use App\Models\PolicyDocument;
use Illuminate\Support\Facades\DB;

class PolicyManager extends Component
{
    use WithPagination;

    public $activeTab = 'items'; // 'items' or 'categories'
    public $search = '';
    public $filterCategoryId = '';
    public $filterGroupName = '';

    // Category Form fields
    public $isCategoryFormOpen = false;
    public $categoryId = null;
    public $categoryName = '';
    public $categorySortOrder = 0;
    public $categoryIsActive = true;

    // Document Form fields
    public $isDocumentFormOpen = false;
    public $documentId = null;
    public $documentCategoryId = '';
    public $documentGroupName = '';
    public $isNewGroup = false;
    public $newGroupName = '';
    public $documentSubGroupName = '';
    public $documentTitle = '';
    public $documentFilePath = '';
    public $documentSortOrder = 1;
    public $documentIsActive = true;
    public $sortPlacement = 'top'; // 'top', 'bottom', 'custom'

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterCategoryId()
    {
        $this->filterGroupName = '';
        $this->resetPage();
    }

    public function updatingFilterGroupName()
    {
        $this->resetPage();
    }

    public function updatedDocumentCategoryId($value)
    {
        $groups = $this->getAvailableGroups();
        if (!in_array($this->documentGroupName, $groups)) {
            $this->documentGroupName = $groups[0] ?? '';
            $this->isNewGroup = empty($groups);
        }
        $this->refreshSortOrder();
    }

    public function updatedDocumentGroupName($value)
    {
        if ($value === '__NEW__') {
            $this->isNewGroup = true;
            $this->newGroupName = '';
            $this->documentGroupName = '';
        } else {
            $this->isNewGroup = false;
        }
        $this->refreshSortOrder();
    }

    public function updatedNewGroupName($value)
    {
        $this->refreshSortOrder();
    }

    public function selectExistingGroup($name)
    {
        $this->documentGroupName = $name;
        $this->isNewGroup = false;
        $this->newGroupName = '';
        $this->refreshSortOrder();
    }

    public function switchToNewGroup()
    {
        $this->isNewGroup = true;
        $this->newGroupName = '';
        $this->documentGroupName = '';
        $this->refreshSortOrder();
    }

    public function cancelNewGroup()
    {
        $groups = $this->getAvailableGroups();
        $this->isNewGroup = false;
        $this->newGroupName = '';
        $this->documentGroupName = $groups[0] ?? '';
        $this->refreshSortOrder();
    }

    public function selectSubGroup($name)
    {
        $this->documentSubGroupName = $name;
    }

    public function setSortPlacement($placement)
    {
        $this->sortPlacement = $placement;
        $this->refreshSortOrder();
    }

    public function refreshSortOrder()
    {
        $group = $this->isNewGroup ? trim($this->newGroupName) : $this->documentGroupName;
        if ($this->sortPlacement === 'top') {
            $this->documentSortOrder = 1;
        } elseif ($this->sortPlacement === 'bottom') {
            $max = PolicyDocument::where('policy_category_id', $this->documentCategoryId)
                ->where('group_name', $group)
                ->max('sort_order') ?? 0;
            $this->documentSortOrder = $max + 1;
        }
    }

    public function getAvailableGroups()
    {
        if (!$this->documentCategoryId) {
            return [];
        }
        return PolicyDocument::where('policy_category_id', $this->documentCategoryId)
            ->whereNotNull('group_name')
            ->where('group_name', '!=', '')
            ->distinct()
            ->pluck('group_name')
            ->toArray();
    }

    public function getFilterGroups()
    {
        if (!$this->filterCategoryId) {
            return PolicyDocument::distinct()->pluck('group_name')->toArray();
        }
        return PolicyDocument::where('policy_category_id', $this->filterCategoryId)
            ->distinct()
            ->pluck('group_name')
            ->toArray();
    }

    public function getAvailableSubGroups()
    {
        $group = $this->isNewGroup ? trim($this->newGroupName) : $this->documentGroupName;
        if (!$this->documentCategoryId || !$group) {
            return [];
        }
        return PolicyDocument::where('policy_category_id', $this->documentCategoryId)
            ->where('group_name', $group)
            ->whereNotNull('sub_group_name')
            ->where('sub_group_name', '!=', '')
            ->distinct()
            ->pluck('sub_group_name')
            ->toArray();
    }

    public function getGroupDocuments()
    {
        $group = $this->isNewGroup ? trim($this->newGroupName) : $this->documentGroupName;
        if (!$this->documentCategoryId || !$group) {
            return collect();
        }
        return PolicyDocument::where('policy_category_id', $this->documentCategoryId)
            ->where('group_name', $group)
            ->orderBy('sort_order')
            ->get();
    }

    // ── CATEGORY CRUD METHODS ──
    public function openCategoryForm($id = null)
    {
        $this->resetValidation();
        $this->categoryId = $id;

        if ($id) {
            $cat = PolicyCategory::findOrFail($id);
            $this->categoryName = $cat->name;
            $this->categorySortOrder = $cat->sort_order;
            $this->categoryIsActive = $cat->is_active;
        } else {
            $this->categoryName = '';
            $this->categorySortOrder = (int) PolicyCategory::max('sort_order') + 1;
            $this->categoryIsActive = true;
        }

        $this->isCategoryFormOpen = true;
    }

    public function closeCategoryForm()
    {
        $this->isCategoryFormOpen = false;
        $this->categoryId = null;
    }

    public function saveCategory()
    {
        $this->validate([
            'categoryName' => 'required|string|max:255',
            'categorySortOrder' => 'required|integer',
            'categoryIsActive' => 'required|boolean',
        ]);

        $data = [
            'name' => $this->categoryName,
            'sort_order' => $this->categorySortOrder,
            'is_active' => $this->categoryIsActive,
        ];

        if ($this->categoryId) {
            $cat = PolicyCategory::findOrFail($this->categoryId);
            $cat->update($data);
            session()->flash('message', 'อัปเดตหมวดหมู่แผนงานเรียบร้อยแล้ว');
        } else {
            PolicyCategory::create($data);
            session()->flash('message', 'เพิ่มหมวดหมู่แผนงานใหม่เรียบร้อยแล้ว');
        }

        $this->closeCategoryForm();
    }

    public function deleteCategory($id)
    {
        $cat = PolicyCategory::findOrFail($id);
        $cat->delete();
        session()->flash('message', 'ลบหมวดหมู่แผนงานเรียบร้อยแล้ว');
    }

    // ── DOCUMENT CRUD METHODS ──
    public function openDocumentForm($id = null)
    {
        $this->resetValidation();
        $this->documentId = $id;

        if ($id) {
            $doc = PolicyDocument::findOrFail($id);
            $this->documentCategoryId = $doc->policy_category_id;
            $this->documentGroupName = $doc->group_name;
            $this->isNewGroup = false;
            $this->newGroupName = '';
            $this->documentSubGroupName = $doc->sub_group_name ?? '';
            $this->documentTitle = $doc->title;
            $this->documentFilePath = $doc->file_path;
            $this->documentSortOrder = $doc->sort_order;
            $this->documentIsActive = $doc->is_active;
            $this->sortPlacement = 'custom';
        } else {
            $this->documentCategoryId = $this->filterCategoryId ?: (PolicyCategory::orderBy('sort_order')->first()?->id ?? '');
            $groups = $this->getAvailableGroups();
            $this->documentGroupName = $this->filterGroupName ?: ($groups[0] ?? '');
            $this->isNewGroup = empty($groups);
            $this->newGroupName = '';
            $this->documentSubGroupName = '';
            $this->documentTitle = '';
            $this->documentFilePath = '';
            $this->documentIsActive = true;
            $this->sortPlacement = 'top'; // Default top placement for new policy
            $this->documentSortOrder = 1;
        }

        $this->isDocumentFormOpen = true;
    }

    public function closeDocumentForm()
    {
        $this->isDocumentFormOpen = false;
        $this->documentId = null;
    }

    public function saveDocument()
    {
        if ($this->isNewGroup) {
            $this->documentGroupName = trim($this->newGroupName);
        }

        $this->validate([
            'documentCategoryId' => 'required|exists:policy_categories,id',
            'documentGroupName' => 'required|string|max:255',
            'documentSubGroupName' => 'nullable|string|max:255',
            'documentTitle' => 'required|string|max:255',
            'documentFilePath' => 'required|string',
            'documentSortOrder' => 'required|integer|min:1',
            'documentIsActive' => 'required|boolean',
        ], [
            'documentCategoryId.required' => 'กรุณาเลือกหมวดหมู่หลัก',
            'documentGroupName.required' => 'กรุณาระบุชื่อกลุ่มย่อย',
            'documentTitle.required' => 'กรุณาระบุชื่อรายการเอกสาร',
            'documentFilePath.required' => 'กรุณาระบุที่อยู่ไฟล์เอกสาร',
            'documentSortOrder.required' => 'กรุณาระบุลำดับการแสดงผล',
        ]);

        DB::transaction(function () {
            $finalSortOrder = (int) $this->documentSortOrder;

            // If creating a new document with 'top' placement, shift existing items in this group down
            if (!$this->documentId && $this->sortPlacement === 'top') {
                PolicyDocument::where('policy_category_id', $this->documentCategoryId)
                    ->where('group_name', $this->documentGroupName)
                    ->increment('sort_order');
                $finalSortOrder = 1;
            } elseif (!$this->documentId && $this->sortPlacement === 'bottom') {
                $max = PolicyDocument::where('policy_category_id', $this->documentCategoryId)
                    ->where('group_name', $this->documentGroupName)
                    ->max('sort_order') ?? 0;
                $finalSortOrder = $max + 1;
            }

            $data = [
                'policy_category_id' => $this->documentCategoryId,
                'group_name' => $this->documentGroupName,
                'sub_group_name' => $this->documentSubGroupName ?: null,
                'title' => $this->documentTitle,
                'file_path' => $this->documentFilePath,
                'sort_order' => $finalSortOrder,
                'is_active' => $this->documentIsActive,
            ];

            if ($this->documentId) {
                $doc = PolicyDocument::findOrFail($this->documentId);
                $doc->update($data);
                session()->flash('message', 'อัปเดตรายการแผนงานย่อยเรียบร้อยแล้ว');
            } else {
                PolicyDocument::create($data);
                session()->flash('message', 'เพิ่มรายการแผนงานย่อยใหม่เรียบร้อยแล้ว');
            }
        });

        $this->closeDocumentForm();
    }

    public function deleteDocument($id)
    {
        $doc = PolicyDocument::findOrFail($id);
        $doc->delete();
        session()->flash('message', 'ลบรายการแผนงานย่อยเรียบร้อยแล้ว');
    }

    public function toggleActive($id)
    {
        $doc = PolicyDocument::findOrFail($id);
        $doc->update(['is_active' => !$doc->is_active]);
        session()->flash('message', 'เปลี่ยนสถานะการแสดงผลเรียบร้อยแล้ว');
    }

    public function moveUp($id)
    {
        $doc = PolicyDocument::findOrFail($id);
        $prevDoc = PolicyDocument::where('policy_category_id', $doc->policy_category_id)
            ->where('group_name', $doc->group_name)
            ->where('sort_order', '<', $doc->sort_order)
            ->orderBy('sort_order', 'desc')
            ->first();

        if ($prevDoc) {
            $currentOrder = $doc->sort_order;
            $doc->update(['sort_order' => $prevDoc->sort_order]);
            $prevDoc->update(['sort_order' => $currentOrder]);
            session()->flash('message', 'ปรับลำดับเอกสารเรียบร้อยแล้ว');
        }
    }

    public function moveDown($id)
    {
        $doc = PolicyDocument::findOrFail($id);
        $nextDoc = PolicyDocument::where('policy_category_id', $doc->policy_category_id)
            ->where('group_name', $doc->group_name)
            ->where('sort_order', '>', $doc->sort_order)
            ->orderBy('sort_order', 'asc')
            ->first();

        if ($nextDoc) {
            $currentOrder = $doc->sort_order;
            $doc->update(['sort_order' => $nextDoc->sort_order]);
            $nextDoc->update(['sort_order' => $currentOrder]);
            session()->flash('message', 'ปรับลำดับเอกสารเรียบร้อยแล้ว');
        }
    }

    public function render()
    {
        $categories = PolicyCategory::orderBy('sort_order')->get();

        if ($this->activeTab === 'categories') {
            $categoriesQuery = PolicyCategory::query()
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('sort_order')
                ->paginate(15);

            return view('livewire.admin.policy-manager', [
                'categoriesList' => $categoriesQuery,
                'allCategories' => $categories,
            ]);
        } else {
            $documentsQuery = PolicyDocument::query()
                ->with('category')
                ->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('group_name', 'like', '%' . $this->search . '%')
                        ->orWhere('sub_group_name', 'like', '%' . $this->search . '%');
                })
                ->when($this->filterCategoryId, function ($query) {
                    $query->where('policy_category_id', $this->filterCategoryId);
                })
                ->when($this->filterGroupName, function ($query) {
                    $query->where('group_name', $this->filterGroupName);
                })
                ->orderBy('policy_category_id')
                ->orderBy('group_name')
                ->orderBy('sort_order')
                ->paginate(15);

            return view('livewire.admin.policy-manager', [
                'documentsList' => $documentsQuery,
                'allCategories' => $categories,
                'availableGroups' => $this->getAvailableGroups(),
                'filterGroups' => $this->getFilterGroups(),
                'availableSubGroups' => $this->getAvailableSubGroups(),
                'groupDocuments' => $this->getGroupDocuments(),
            ]);
        }
    }
}
