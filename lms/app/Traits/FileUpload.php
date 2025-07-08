<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

trait FileUpload
{
    public function uploadFile(UploadedFile $file, string $directory = 'uploads'): string
    {
        try {
            $filename = 'educore_' . uniqid() . '.' . $file->getClientOriginalExtension();

            // Store directly in public/storage directory
            $targetDirectory = public_path('storage/' . $directory);

            // Create directory if it doesn't exist
            if (!File::exists($targetDirectory)) {
                File::makeDirectory($targetDirectory, 0755, true);
            }

            // Move the uploaded file
            $file->move($targetDirectory, $filename);

            // Verify file was moved successfully
            $filePath = $targetDirectory . '/' . $filename;
            if (!file_exists($filePath)) {
                throw new Exception('File was not uploaded successfully');
            }

            // Return the correct URL using asset() helper
            return asset('storage/' . $directory . '/' . $filename);

        } catch (Exception $e) {
            throw new Exception('File upload failed: ' . $e->getMessage());
        }
    }

    public function deleteFile(?string $path): bool
    {
        if ($path) {
            // Extract the relative path from the asset URL
            $relativePath = str_replace(asset(''), '', $path);
            $fullPath = public_path(ltrim($relativePath, '/'));

            if (File::exists($fullPath)) {
                return File::delete($fullPath);
            }
        }
        return false;
    }
}
