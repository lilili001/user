<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

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
<<<<<<< HEAD
        //$this->call(SentinelGroupSeedTableSeeder::class);
=======

        $this->call(SentinelGroupSeedTableSeeder::class);
>>>>>>> a981f784849191c6c07d68abf994110992498ea7
    }
}
