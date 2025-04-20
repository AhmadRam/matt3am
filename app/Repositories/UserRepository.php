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
     * Create User with profile image upload.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    public function create($data)
    {
        $user = parent::create($data);

        if (!empty($data['profile_image'])) {
            Helper::uploadImage(
                ['profile_image' => $data['profile_image']],
                $user,
                'profile_image'
            );
        }

        return $user->fresh();
    }

    /**
     * Update User with optional profile image update.
     *
     * @param  array  $data
     * @param  int  $id
     * @return \App\Models\User
     */
    public function update(array $data, $id)
    {
        $user = $this->find($id);
        $user = parent::update($data, $id);

        if (array_key_exists('profile_image', $data)) {
            if ($data['profile_image'] === null) {
                if ($user->profile_image) {
                    Storage::delete($user->profile_image);
                    $user->profile_image = null;
                    $user->save();
                }
            } else {
                Helper::uploadImage(
                    ['profile_image' => $data['profile_image']],
                    $user,
                    'profile_image'
                );
            }
        }

        return $user->fresh();
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
