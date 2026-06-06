<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageHelper
{
    /**
     * Convert uploaded image to WebP format with compression.
     * Accepts any image size, converts and compresses server-side.
     *
     * @param UploadedFile $file
     * @param string $folder  Subfolder in public/uploads/
     * @param int $quality    WebP quality (1-100)
     * @param int|null $maxWidth  Max width to resize (null = no resize)
     * @return string|null  Relative path from public/uploads/ or null on failure
     */
    public static function convertToWebp(UploadedFile $file, string $folder = 'images', int $quality = 80, ?int $maxWidth = 1920): ?string
    {
        try {
            $mime = $file->getMimeType();

            // If PDF, store as-is (no conversion)
            if ($mime === 'application/pdf') {
                return $file->store($folder, 'public_uploads');
            }

            // Create GD image from uploaded file
            $source = match ($mime) {
                'image/jpeg', 'image/jpg' => imagecreatefromjpeg($file->getPathname()),
                'image/png' => imagecreatefrompng($file->getPathname()),
                'image/gif' => imagecreatefromgif($file->getPathname()),
                'image/webp' => imagecreatefromwebp($file->getPathname()),
                'image/bmp' => imagecreatefrombmp($file->getPathname()),
                default => null,
            };

            if (!$source) {
                // Fallback: store original if GD can't handle it
                return $file->store($folder, 'public_uploads');
            }

            // Get dimensions
            $origWidth = imagesx($source);
            $origHeight = imagesy($source);

            // Resize if wider than maxWidth
            if ($maxWidth && $origWidth > $maxWidth) {
                $ratio = $maxWidth / $origWidth;
                $newWidth = $maxWidth;
                $newHeight = (int) round($origHeight * $ratio);

                $resized = imagecreatetruecolor($newWidth, $newHeight);

                // Preserve transparency for PNG
                imagealphablending($resized, false);
                imagesavealpha($resized, true);

                imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
                imagedestroy($source);
                $source = $resized;
            }

            // Generate unique filename
            $filename = $folder . '/' . Str::uuid() . '.webp';
            $fullPath = public_path('uploads/' . $filename);

            // Ensure directory exists
            $dir = dirname($fullPath);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            // Convert to WebP
            imagepalettetotruecolor($source);
            imagealphablending($source, true);
            imagesavealpha($source, true);
            imagewebp($source, $fullPath, $quality);
            imagedestroy($source);

            return $filename;
        } catch (\Throwable $e) {
            // Fallback: store original
            return $file->store($folder, 'public_uploads');
        }
    }
}
