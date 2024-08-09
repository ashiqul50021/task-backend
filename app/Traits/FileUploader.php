<?php

namespace App\Traits;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait FileUploader
{
    /*
     |--------------------------------------------------------------------------
     | UPLOAD IMAGE
     |--------------------------------------------------------------------------
    */
    public function uploadImage($uploadImage, $model, $database_field_name, $basePath, $width, $height)
    {
        if ($uploadImage) {
            try {

                $basePath = 'assets/uploads';
                $image_name = $model->id . time() . '-' . rand(11111, 999999) . '.' . 'webp';


                if (file_exists($model->$database_field_name) && $model->$database_field_name != '') {
                    unlink($model->$database_field_name);
                }

                if (!is_dir($basePath)) {
                    \File::makeDirectory($basePath, 493, true);
                }

                Image::make($uploadImage->getRealPath())
                    ->encode('webp', 90)
                    ->fit($width, $height)
                    ->save($basePath . '/' . $image_name);

                $model->update([$database_field_name => ($basePath . '/' . $image_name)]);
            } catch (\Exception $ex) {
            }
        }
    }
}
