<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Upload an image to the specified directory.
     *
     * @param \Illuminate\Http\UploadedFile $image
     * @param string $directory
     * @return string|false The path of the uploaded image or false on failure.
     */
    public static function uploadImage($image, $directory)
    {
        if ($image->isValid()) {
            return $image->store($directory, 'uploads');
        }
        return false;
    }

    /**
     * Delete an image from the storage.
     *
     * @param string $path
     * @return bool
     */
    public static function deleteImage($path)
    {
        return Storage::disk('uploads')->exists($path)
            ? Storage::disk('uploads')->delete($path)
            : false;
    }
}
