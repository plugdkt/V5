<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Media;
use Illuminate\Support\Facades\File;

class ScanDocs extends Command
{
    protected $signature = 'medsci:scan-docs';
    protected $description = 'Scan files in storage/app/public/medsci_doc and register them in the media table';

    public function handle()
    {
        $dirPath = storage_path('app/public/medsci_doc');
        
        if (!File::isDirectory($dirPath)) {
            $this->error("Directory does not exist: $dirPath");
            return 1;
        }

        $this->info("Scanning directory: $dirPath");

        $files = File::allFiles($dirPath);
        $count = 0;

        foreach ($files as $file) {
            // Get path relative to storage/app/public
            $absolutePath = str_replace('\\', '/', $file->getRealPath());
            $publicPath = str_replace('\\', '/', storage_path('app/public'));
            $relativePath = ltrim(str_replace($publicPath, '', $absolutePath), '/');


            // Check if already registered
            $exists = Media::where('file_path', $relativePath)->exists();

            if (!$exists) {
                $mimeType = File::mimeType($absolutePath) ?: 'application/octet-stream';
                $size = File::size($absolutePath);

                Media::create([
                    'name' => $file->getFilename(),
                    'file_name' => $file->getFilename(),
                    'file_path' => $relativePath,
                    'mime_type' => $mimeType,
                    'size' => $size,
                    'uploaded_by' => 1, // Default Admin
                ]);

                $this->line("Registered: $relativePath");
                $count++;
            }
        }

        $this->info("Scan completed! Registered $count new files.");
        return 0;
    }
}
