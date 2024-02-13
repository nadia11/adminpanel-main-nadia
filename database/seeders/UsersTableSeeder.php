<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'SuperAdmin',
            'role_id' => 1,
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('SuperAdmin'),
            'verified'=>1,
            'mobile' => '01998369826',
            'status' => 'Approved'
        ]);

        DB::table('users')->insert([
            'name' => 'Aynul Hoque',
            'role_id' => 1,
            'email' => 'aynul@gmail.com',
            'password' => bcrypt('Aynul'),
            'verified'=>1,
            'mobile' => '01976355569',
            'status' => 'Approved'
        ]);

        DB::table('users')->insert([
            'name' => 'Demo',
            'role_id' => 1,
            'email' => 'demo@gmail.com',
            'password' => bcrypt('demo'),
            'verified'=>1,
            'mobile' => '01723939191',
            'status' => 'Approved'
        ]);
        //DB::table('users')->insert([ 'name' =>  str_random(10), 'role_id' => 3,    'email' => str_random(10).'@gmail.com', 'password' => bcrypt('secret'),  'verified'=>0, 'status' => 'Pending' ]);
    }
}
