<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $user = new User;
        $user->code = 'U-00001';
        $user->first_name = 'System';
        $user->last_name = 'Developer';
        $user->email = 'developer@developer.com';
        $user->password = bcrypt('developer@123');
        $user->status = 1;
        $user->save();

        // $this->call("OthersTableSeeder");
    }
}
