<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * Upload images dynamically with support for translated fields
     *
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $fieldName
     * @param string|null $locale
     * @param string|null $translationField
     * @return void
     */
    public static function uploadImage(
        array $data,
        $model,
        string $fieldName = 'image',
        ?string $locale = null,
        ?string $translationField = null
    ) {
        if (!isset($data[$fieldName]) || empty($data[$fieldName])) {
            return;
        }

        $request = request();
        $isTranslated = !is_null($locale) && !is_null($translationField);
        $actualField = $isTranslated ? $translationField : $fieldName;

        // Prepare directory path
        $modelName = strtolower(class_basename($model));
        $dir = "{$modelName}/{$model->id}";
        $dir .= $isTranslated ? "/{$locale}" : '';

        // Handle file upload
        if ($isTranslated ? $request->hasFile("translations.{$locale}.{$fieldName}") : $request->hasFile($fieldName)) {
            $file = $isTranslated
                ? $request->file("translations.{$locale}.{$fieldName}")
                : $request->file($fieldName);

            // Delete old file if exists
            if ($isTranslated) {
                $oldFile = $model->translate($locale)?->{$translationField};
            } else {
                $oldFile = $model->{$fieldName};
            }

            if ($oldFile) {
                Storage::delete($oldFile);
            }

            // Store new file
            $path = $file->store($dir);

            // Update model
            if ($isTranslated) {
                $translation = $model->translateOrNew($locale);
                $translation->{$translationField} = $path;
                $translation->save();
            } else {
                $model->{$fieldName} = $path;
                $model->save();
            }
        }
    }
}
