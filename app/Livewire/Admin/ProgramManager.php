<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Program;
use Illuminate\Support\Str;

class ProgramManager extends Component
{
    use WithPagination;

    public $search = '';
    public $isFormOpen = false;
    public $programId = null;

    // Form fields
    public $slug = '';
    public $title_th = '';
    public $title_en = '';
    public $degree_full_th = '';
    public $degree_abbr_th = '';
    public $degree_full_en = '';
    public $degree_abbr_en = '';
    public $credits = 130;
    public $duration_years = 4;
    public $fee_per_semester = 16000;
    public $curriculum_year = '2565';
    public $overview = '';
    public $hero_image = '';
    public $hero_color_from = '#064731';
    public $hero_color_to = '#0B2545';
    public $is_active = true;
    public $sort_order = 0;

    // Dynamic Lists
    public $plos_input = [];
    public $careers_input = [];

    // Curriculum year fields
    public $curriculum_year1 = '';
    public $curriculum_year2 = '';
    public $curriculum_year3 = '';
    public $curriculum_year4 = '';

    protected $rules = [
        'slug' => 'required|string|max:255',
        'title_th' => 'required|string|max:255',
        'title_en' => 'required|string|max:255',
        'degree_full_th' => 'required|string|max:255',
        'degree_abbr_th' => 'required|string|max:255',
        'degree_full_en' => 'required|string|max:255',
        'degree_abbr_en' => 'required|string|max:255',
        'credits' => 'required|integer',
        'duration_years' => 'required|integer',
        'fee_per_semester' => 'required|integer',
        'curriculum_year' => 'required|string|max:255',
        'overview' => 'nullable|string',
        'hero_image' => 'nullable|string|max:255',
        'hero_color_from' => 'required|string|max:7',
        'hero_color_to' => 'required|string|max:7',
        'is_active' => 'required|boolean',
        'sort_order' => 'required|integer',
        'curriculum_year1' => 'nullable|string',
        'curriculum_year2' => 'nullable|string',
        'curriculum_year3' => 'nullable|string',
        'curriculum_year4' => 'nullable|string',
        'plos_input.*.code' => 'required|string|max:50',
        'plos_input.*.description' => 'required|string',
        'careers_input.*.icon' => 'required|string|max:50',
        'careers_input.*.title' => 'required|string|max:255',
        'careers_input.*.description' => 'required|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedTitleTh($value)
    {
        if (empty($this->slug)) {
            $this->slug = Str::slug($value);
        }
    }

    public function openForm($id = null)
    {
        $this->resetValidation();
        $this->programId = $id;

        if ($id) {
            $program = Program::findOrFail($id);
            $this->slug = $program->slug;
            $this->title_th = $program->title_th;
            $this->title_en = $program->title_en;
            $this->degree_full_th = $program->degree_full_th;
            $this->degree_abbr_th = $program->degree_abbr_th;
            $this->degree_full_en = $program->degree_full_en;
            $this->degree_abbr_en = $program->degree_abbr_en;
            $this->credits = $program->credits;
            $this->duration_years = $program->duration_years;
            $this->fee_per_semester = $program->fee_per_semester;
            $this->curriculum_year = $program->curriculum_year;
            $this->overview = $program->overview;
            $this->hero_image = $program->hero_image;
            $this->hero_color_from = $program->hero_color_from;
            $this->hero_color_to = $program->hero_color_to;
            $this->is_active = $program->is_active;
            $this->sort_order = $program->sort_order;

            $this->plos_input = $program->plos ?? [];
            $this->careers_input = $program->careers ?? [];

            $curr = $program->curriculum ?? [];
            $this->curriculum_year1 = $curr['year1'] ?? '';
            $this->curriculum_year2 = $curr['year2'] ?? '';
            $this->curriculum_year3 = $curr['year3'] ?? '';
            $this->curriculum_year4 = $curr['year4'] ?? '';
        } else {
            $this->slug = '';
            $this->title_th = '';
            $this->title_en = '';
            $this->degree_full_th = '';
            $this->degree_abbr_th = '';
            $this->degree_full_en = '';
            $this->degree_abbr_en = '';
            $this->credits = 130;
            $this->duration_years = 4;
            $this->fee_per_semester = 16000;
            $this->curriculum_year = '2565';
            $this->overview = '';
            $this->hero_image = '';
            $this->hero_color_from = '#064731';
            $this->hero_color_to = '#0B2545';
            $this->is_active = true;
            $this->sort_order = Program::max('sort_order') + 1;

            $this->plos_input = [
                ['code' => 'PLO1', 'description' => '']
            ];
            $this->careers_input = [
                ['icon' => '🔬', 'title' => '', 'description' => '']
            ];

            $this->curriculum_year1 = '';
            $this->curriculum_year2 = '';
            $this->curriculum_year3 = '';
            $this->curriculum_year4 = '';
        }

        $this->isFormOpen = true;
    }

    public function closeForm()
    {
        $this->isFormOpen = false;
        $this->programId = null;
    }

    public function addPlo()
    {
        $nextNum = count($this->plos_input) + 1;
        $this->plos_input[] = ['code' => 'PLO' . $nextNum, 'description' => ''];
    }

    public function removePlo($index)
    {
        unset($this->plos_input[$index]);
        $this->plos_input = array_values($this->plos_input);
    }

    public function addCareer()
    {
        $this->careers_input[] = ['icon' => '💼', 'title' => '', 'description' => ''];
    }

    public function removeCareer($index)
    {
        unset($this->careers_input[$index]);
        $this->careers_input = array_values($this->careers_input);
    }

    public function saveProgram()
    {
        $this->validate();

        // Unique slug check
        $slugCheck = Program::where('slug', $this->slug)
            ->when($this->programId, function ($query) {
                $query->where('id', '!=', $this->programId);
            })->exists();

        if ($slugCheck) {
            $this->addError('slug', 'URL Slug นี้ถูกใช้งานแล้ว กรุณาระบุชื่ออื่น');
            return;
        }

        $data = [
            'slug' => $this->slug,
            'title_th' => $this->title_th,
            'title_en' => $this->title_en,
            'degree_full_th' => $this->degree_full_th,
            'degree_abbr_th' => $this->degree_abbr_th,
            'degree_full_en' => $this->degree_full_en,
            'degree_abbr_en' => $this->degree_abbr_en,
            'credits' => $this->credits,
            'duration_years' => $this->duration_years,
            'fee_per_semester' => $this->fee_per_semester,
            'curriculum_year' => $this->curriculum_year,
            'overview' => $this->overview,
            'hero_image' => $this->hero_image,
            'hero_color_from' => $this->hero_color_from,
            'hero_color_to' => $this->hero_color_to,
            'is_active' => $this->is_active,
            'sort_order' => $this->sort_order,
            'plos' => $this->plos_input,
            'careers' => $this->careers_input,
            'curriculum' => [
                'year1' => $this->curriculum_year1,
                'year2' => $this->curriculum_year2,
                'year3' => $this->curriculum_year3,
                'year4' => $this->curriculum_year4,
            ]
        ];

        if ($this->programId) {
            $program = Program::findOrFail($this->programId);
            $program->update($data);
            session()->flash('message', 'อัปเดตข้อมูลหลักสูตรสำเร็จแล้ว');
        } else {
            Program::create($data);
            session()->flash('message', 'เพิ่มหลักสูตรใหม่สำเร็จแล้ว');
        }

        $this->closeForm();
    }

    public function deleteProgram($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();
        session()->flash('message', 'ลบหลักสูตรเรียบร้อยแล้ว');
    }

    public function render()
    {
        $programsList = Program::where('title_th', 'like', '%' . $this->search . '%')
            ->orWhere('title_en', 'like', '%' . $this->search . '%')
            ->orderBy('sort_order', 'asc')
            ->paginate(10);

        return view('livewire.admin.program-manager', [
            'programsList' => $programsList
        ]);
    }
}
