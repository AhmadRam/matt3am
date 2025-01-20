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
     * Create Customer.
     *
     * @param  array $data
     * @return \App\Models\Customer
     */
    public function create($data)
    {
        $images['image'] = $data['image'] ?? null;
        unset($data['image']);
        $customer = parent::create($data);

        Helper::uploadImages($images, $customer, 'image');

        return $customer;
    }

    /**
     * Update Customer.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \App\Models\Customer
     */
    public function update(array $data, $id)
    {
        $customer = $this->find($id);
        $images['image'] = $data['image'] ?? null;
        unset($data['image']);
        // $customer = parent::update($data, $id);

        Helper::uploadImages($images, $customer, 'image');

        return $customer;
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
