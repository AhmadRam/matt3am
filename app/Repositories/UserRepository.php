<?php

namespace App\Repositories;

use App\Eloquent\Repository;
use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class UserRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return User::class;
    }


    /**
     * Create User.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    public function create($data)
    {
        $images['profile_image'] = $data['profile_image'] ?? null;
        unset($data['profile_image']);
        $user = parent::create($data);

        Helper::uploadImages($images, $user, 'profile_image');

        return $user;
    }

    /**
     * Update User.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \App\Models\User
     */
    public function update(array $data, $id)
    {
        $user = $this->find($id);
        $images['profile_image'] = $data['profile_image'] ?? null;
        unset($data['profile_image']);
        $user = parent::update($data, $id);

        Helper::uploadImages($images, $user, 'profile_image');

        return $user;
    }


    /**
     * Delete User.
     *
     * @param  int  $id
     * @return \App\Models\User
     */
    public function destroy($id)
    {
        $user = $this->find($id);

        if ($user->profile_image) {
            Storage::delete($user->profile_image);
        }

        $deleted = parent::delete($id);

        return $deleted;
    }
}
