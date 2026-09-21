<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;

class SettingsManager extends Component
{
    public $site_name_th;
    public $site_name_en;
    public $contact_phone;
    public $contact_email;
    public $contact_address;
    public $social_facebook;
    public $social_youtube;
    
    public $stat_years;
    public $stat_staff;
    public $stat_alumni;
    public $stat_research;

    public $successMessage = '';

    public function mount()
    {
        $this->site_name_th = Setting::get('site_name_th', 'คณะวิทยาศาสตร์การแพทย์ มหาวิทยาลัยพะเยา');
        $this->site_name_en = Setting::get('site_name_en', 'School of Medical Sciences, University of Phayao');
        $this->contact_phone = Setting::get('contact_phone', '054-466-666 ต่อ 3811');
        $this->contact_email = Setting::get('contact_email', 'medsci@up.ac.th');
        $this->contact_address = Setting::get('contact_address', '19 หมู่ 2 ต.แม่กา อ.เมือง จ.พะเยา 56000');
        $this->social_facebook = Setting::get('social_facebook', 'https://www.facebook.com/medsci.up');
        $this->social_youtube = Setting::get('social_youtube', 'https://www.youtube.com');
        
        $this->stat_years = Setting::get('stat_years', 15);
        $this->stat_staff = Setting::get('stat_staff', 60);
        $this->stat_alumni = Setting::get('stat_alumni', 1200);
        $this->stat_research = Setting::get('stat_research', 200);
    }

    public function saveSettings()
    {
        Setting::set('site_name_th', $this->site_name_th, 'string', 'general');
        Setting::set('site_name_en', $this->site_name_en, 'string', 'general');
        Setting::set('contact_phone', $this->contact_phone, 'string', 'contact');
        Setting::set('contact_email', $this->contact_email, 'string', 'contact');
        Setting::set('contact_address', $this->contact_address, 'string', 'contact');
        Setting::set('social_facebook', $this->social_facebook, 'string', 'contact');
        Setting::set('social_youtube', $this->social_youtube, 'string', 'contact');
        
        Setting::set('stat_years', (int) $this->stat_years, 'integer', 'stats');
        Setting::set('stat_staff', (int) $this->stat_staff, 'integer', 'stats');
        Setting::set('stat_alumni', (int) $this->stat_alumni, 'integer', 'stats');
        Setting::set('stat_research', (int) $this->stat_research, 'integer', 'stats');

        $this->successMessage = 'บันทึกการตั้งค่าระบบเสร็จสมบูรณ์!';
    }

    public function render()
    {
        return view('livewire.admin.settings-manager');
    }
}
