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
        $restaurant = parent::create([
            'phone_code' => $data['phone_code'],
            'phone' => $data['phone'],
            'status' => boolval($data['status']),
            'subscription_start_date' => $data['subscription_start_date'],
            'subscription_end_date' => $data['subscription_end_date'],
            'user_id' => $data['user_id'],
            'currency_id' => $data['currency_id']
        ]);

        // Handle translations
        foreach ($data['translations'] ?? [] as $locale => $translation) {
            $translationData = [
                'name' => $translation['name'],
                'description' => $translation['description'],
                'address' => $translation['address'],
                'meta_title' => $translation['meta_title'] ?? null,
                'meta_keywords' => $translation['meta_keywords'] ?? null,
                'meta_description' => $translation['meta_description'] ?? null,
                'locale' => $locale
            ];

            Helper::uploadImage(
                ['logo' => $translation['logo'] ?? null],
                $restaurant,
                'logo',
                $locale,
                'logo'
            );

            $restaurant->translations()->create($translationData);
        }

        return $restaurant;
    }

    /**
     * Update Restaurant with translations and logo.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \App\Models\Restaurant
     */
    public function update(array $data, $id)
    {
        $restaurant = $this->find($id);

        // تحديث البيانات الأساسية
        $restaurantData = [
            'phone_code' => $data['phone_code'] ?? $restaurant->phone_code,
            'phone' => $data['phone'] ?? $restaurant->phone,
            'status' => $data['status'] ?? $restaurant->status,
            'subscription_start_date' => $data['subscription_start_date'] ?? $restaurant->subscription_start_date,
            'subscription_end_date' => $data['subscription_end_date'] ?? $restaurant->subscription_end_date,
            'user_id' => $data['user_id'] ?? $restaurant->user_id,
            'currency_id' => $data['currency_id'] ?? $restaurant->currency_id
        ];

        $restaurant = parent::update($restaurantData, $id);

        // تحديث الترجمات
        if (isset($data['translations'])) {
            foreach ($data['translations'] as $locale => $translationData) {
                // تحميل لوجو اللغة إذا موجود
                if (isset($translationData['logo'])) {
                    Helper::uploadImage(
                        ['logo' => $translationData['logo']],
                        $restaurant,
                        'logo',
                        $locale,
                        'logo'
                    );
                    unset($translationData['logo']);
                }

                // تحديث أو إنشاء الترجمة
                $restaurant->translateOrNew($locale)->fill($translationData);
            }
            $restaurant->save();
        }

        return $restaurant->load('translations');
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
