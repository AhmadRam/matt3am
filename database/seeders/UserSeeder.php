<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('username', 'admin')->first();
        if (is_null($user)) {
            $user = new User();
            $user->username = "admin";
            $user->password = Hash::make('123456');
            $user->full_name = "admin";
            $user->email = "admin@matt3am.com";
            $user->status = true;
            $user->profile_image = "";
            $user->restaurant_id = null;
            $user->save();
        }
    }
}
