<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Helpers\Helper;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;

class CustomerRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return Customer::class;
    }


    /**
     * Update Customer with optional image update.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \App\Models\Customer
     */
    public function update(array $data, $id)
    {
        $customer = $this->find($id);

        $customer = parent::update($data, $id);

        if (isset($data['image'])) {
            Helper::uploadImage(
                ['image' => $data['image']],
                $customer,
                'image'
            );
        } elseif (array_key_exists('image', $data) && $data['image'] === null) {

            if ($customer->image) {
                Storage::delete($customer->image);
                $customer->image = null;
                $customer->save();
            }
        }

        return $customer->fresh();
    }


    /**
     * Delete Customer.
     *
     * @param  int  $id
     * @return \App\Models\Customer
     */
    public function destroy($id)
    {
        $customer = $this->find($id);

        if ($customer->image) {
            Storage::delete($customer->image);
        }

        $deleted = parent::delete($id);

        return $deleted;
    }
}
