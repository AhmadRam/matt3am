<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class Helper
{
    /**
     * Upload images for any model dynamically.
     *
     * @param  array  $data
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string $type
     * @return void
     */
    public static function uploadImages(array $data, $model, string $type = 'image')
    {
        if (isset($data[$type]) && $data[$type] != null && $data[$type] != '') {
            $request = request();

            // Determine the directory based on the model class and ID
            $modelName = strtolower(class_basename($model));
            $dir = $modelName . '/' . $model->id;

            if ($request->hasFile($type)) {
                // Delete the existing file if it exists
                if ($model->{$type}) {
                    Storage::delete($model->{$type});
                }

                // $path = $dir . '/' . time() . '.webp';
                // Storage::put($path, Image::make($request->file($type))->encode('webp'));

                // // Store the new file and update the model
                // $model->{$type} = $path;

                $model->{$type} = $request->file($type)->store($dir);

                $model->save();
            }
        }
    }
}
