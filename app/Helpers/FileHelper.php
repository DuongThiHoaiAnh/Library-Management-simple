<?php

namespace App\Helpers;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FileHelper
{
    /**
     * Upload ảnh lên Cloudinary
     *
     * @param UploadedFile|null $file
     * @param string $folder
     * @return string|null
     */
    public static function uploadImageToCloudinary(?UploadedFile $file, string $folder = 'books')
    {
        if (!$file || !$file->isValid()) {
            Log::warning('❌ FileHelper: Không nhận được file hợp lệ để upload.');
            return null;
        }

        try {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename = Str::slug($originalName) . '-' . time();

            $uploaded = Cloudinary::upload($file->getRealPath(), [
                'folder' => $folder,
                'public_id' => $filename,
                'overwrite' => true,
            ]);

            if (!$uploaded) {
                Log::error('❌ FileHelper: Cloudinary upload trả về null.');
                return null;
            }

            return $uploaded->getSecurePath();
        } catch (\Exception $e) {
            Log::error('❌ Lỗi upload Cloudinary: ' . $e->getMessage());
            return null;
        }
    }
}
