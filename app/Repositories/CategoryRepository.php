<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Helpers\Helper;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Category::class;
    }

    /**
     * Create Category.
     *
     * @param  array $data
     * @return \App\Models\Category
     */
    public function create($data)
    {
        $images['image'] = $data['image'] ?? null;
        unset($data['image']);
        $category = parent::create($data);

        Helper::uploadImages($images, $category, 'image');

        return $category;
    }

    /**
     * Update Category.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \App\Models\Category
     */
    public function update(array $data, $id)
    {
        $category = $this->find($id);
        $images['image'] = $data['image'] ?? null;
        unset($data['image']);
        $category = parent::update($data, $id);

        Helper::uploadImages($images, $category, 'image');

        return $category;
    }


    /**
     * Delete Category.
     *
     * @param  int  $id
     * @return \App\Models\Category
     */
    public function destroy($id)
    {
        $category = $this->find($id);

        if ($category->image) {
            Storage::delete($category->image);
        }

        $deleted = parent::delete($id);

        return $deleted;
    }
}
