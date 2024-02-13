<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->insert([ 'role_name'=>'SuperAdmin', 'role_description' => 'Control all section and can develop software', 'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('user_roles')->insert([ 'role_name'=>'Admin', 'role_description' => 'Control all section', 'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('user_roles')->insert([ 'role_name'=>'Editor', 'role_description' => 'Only edit content', 'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('user_roles')->insert([ 'role_name'=>'User', 'role_description' => 'Only edit content', 'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('user_roles')->insert([ 'role_name'=>'member', 'role_description' => 'Only edit content', 'created_at' => date('Y-m-d H:i:s') ]);
    }
}
