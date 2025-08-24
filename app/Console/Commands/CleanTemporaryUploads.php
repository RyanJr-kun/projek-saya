<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CleanTemporaryUploads extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'uploads:clean-tmp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up temporary files older than 24 hours from storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting cleanup of temporary upload directories...');

        // Ambil daftar direktori dari file konfigurasi
        $directories = config('uploads.temporary_directories', []);
        $cutoff = now()->subHours(24); // Tentukan batas waktu (misal: 24 jam)
        $deletedCount = 0;

        foreach ($directories as $directory) {
            if (!Storage::disk('public')->exists($directory)) {
                continue;
            }

            $files = Storage::disk('public')->files($directory);

            foreach ($files as $file) {
                // Jangan hapus file .gitignore
                if (basename($file) === '.gitignore') {
                    continue;
                }

                if (Storage::disk('public')->lastModified($file) < $cutoff->getTimestamp()) {
                    Storage::disk('public')->delete($file);
                    $deletedCount++;
                    $this->line("Deleted: {$file}");
                }
            }
        }

        $this->info("Cleanup complete. Deleted {$deletedCount} old temporary files.");
        return 0;
    }
}
