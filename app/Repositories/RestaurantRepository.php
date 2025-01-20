<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Helpers\Helper;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Storage;

class RestaurantRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Restaurant::class;
    }

    /**
     * Create Restaurant.
     *
     * @param  array $data
     * @return \App\Models\Restaurant
     */
    public function create($data)
    {
        $logo['logo'] = $data['logo'] ?? null;
        unset($data['logo']);
        $restaurant = parent::create($data);

        Helper::uploadImages($logo, $restaurant, 'logo');

        return $restaurant;
    }

    /**
     * Update Restaurant.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \App\Models\Restaurant
     */
    public function update(array $data, $id)
    {
        $restaurant = $this->find($id);
        $logo['logo'] = $data['logo'] ?? null;
        unset($data['logo']);
        $restaurant = parent::update($data, $id);

        Helper::uploadImages($logo, $restaurant, 'logo');

        return $restaurant;
    }


    /**
     * Delete Restaurant.
     *
     * @param  int  $id
     * @return \App\Models\Restaurant
     */
    public function destroy($id)
    {
        $restaurant = $this->find($id);

        if ($restaurant->logo) {
            Storage::delete($restaurant->logo);
        }

        $deleted = parent::delete($id);

        return $deleted;
    }
}
