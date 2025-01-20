<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ProductImageRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return ProductImage::class;
    }


    /**
     * Get product directory.
     *
     * @param  \Webkul\Product\Contracts\Product $product
     * @return string
     */
    public function getProductDirectory($product): string
    {
        return 'product/' . $product->id;
    }

    /**
     * Upload.
     *
     * @param  array  $data
     * @param  \App\Models\Product  $product
     * @param  string  $uploadFileType
     * @return void
     */
    public function upload($data, $product, string $uploadFileType): void
    {

        /**
         * Previous model ids for filtering.
         */
        $previousIds = $product->images()->pluck('id');

        if (!empty($data[$uploadFileType])) {
            foreach ($data[$uploadFileType] as $indexOrModelId => $file) {
                if ($file instanceof UploadedFile) {

                    $dir = $this->getProductDirectory($product) . '/' . time() . '_' . rand(1, 100) . '_' . $indexOrModelId . '.webp';
                    // Storage::put($path, Image::make($file)->encode('webp'));
                    $path = $file->store($dir);

                    if (!$this->model->where('path', $path)->exists()) {
                        $this->create([
                            'type'       => $uploadFileType,
                            'path'       => $path,
                            'product_id' => $product->id,
                            'position'   => $indexOrModelId,
                        ]);
                    }
                } else {
                    /**
                     * Filter out existing models because new model positions are already setup by index.
                     */
                    if (!empty($data[$uploadFileType]['positions'])) {
                        $positions = collect($data[$uploadFileType]['positions'])->keys()->filter(function ($position) {
                            return is_numeric($position);
                        });

                        $this->update([
                            'position' => $positions->search($indexOrModelId),
                        ], $indexOrModelId);
                    }

                    if (is_numeric($index = $previousIds->search($indexOrModelId))) {
                        $previousIds->forget($index);
                    }
                }
            }
        }

        foreach ($previousIds as $indexOrModelId) {
            if (!$model = $this->find($indexOrModelId)) {
                continue;
            }

            Storage::delete($model->path);

            $this->delete($indexOrModelId);
        }
    }
}
