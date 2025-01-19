<?php

namespace App\Repositories;

use App\Contracts\ProductImage;
use App\Eloquent\Repository;
use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductRepository extends Repository
{

    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Product::class;
    }


    /**
     * Create Product.
     *
     * @param  array $data
     * @return \App\Models\Product
     */
    public function create($data)
    {
        $images['image'] = $data['image'] ?? [];
        unset($data['image']);

        $product = parent::create($data);

        app(ProductImageRepository::class)->upload($images, $product, 'image');

        return $product;
    }

    /**
     * Update Product.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \App\Models\Product
     */
    public function update(array $data, $id)
    {
        $product = $this->find($id);
        $images['image'] = $data['image'] ?? null;
        unset($data['image']);
        $product = parent::update($data, $id);

        app(ProductImageRepository::class)->upload($images, $product, 'image');

        return $product;
    }


    /**
     * Delete Product.
     *
     * @param  int  $id
     * @return \App\Models\Product
     */
    public function destroy($id)
    {
        $product = $this->find($id);

        app(ProductImageRepository::class)->upload($product, [], 'image');

        return true;
    }
}
