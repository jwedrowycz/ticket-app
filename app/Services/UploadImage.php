<?php

namespace App\Services;

class UploadImage {

    public static function upload($image, $storagePath, $value = '')
    {
        $imageName = time() . $value . $image->extension();
        $image->move(storage_path($storagePath), $imageName);
        return $imageName;
    }
}