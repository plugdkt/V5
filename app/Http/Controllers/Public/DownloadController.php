<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DownloadableFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function download($id)
    {
        $file = DownloadableFile::where('active', true)->findOrFail($id);

        $file->increment('download_count');

        // Try multiple storage paths in order:
        // 1. Admin-uploaded files stored as hashes under public/downloads/
        // 2. Legacy files stored directly e.g. medsci_doc/Form/F-01.pdf
        $candidates = [
            'public/downloads/' . $file->filename,
            $file->filename,
        ];

        foreach ($candidates as $path) {
            if (Storage::exists($path)) {
                return Storage::download($path, $file->original_name);
            }
        }

        return response()->json([
            'message'   => 'ไฟล์เอกสารกำลังอยู่ระหว่างการจัดเตรียมเข้าระบบจัดเก็บข้อมูลใหม่',
            'file_info' => [
                'title'    => $file->title,
                'filename' => $file->original_name,
            ],
        ], 404, ['Content-Type' => 'application/json; charset=utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
