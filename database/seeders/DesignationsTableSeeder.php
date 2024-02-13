<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('designations')->insert([ 'department_id'=> '1', 'designation_name' => 'Head of Administration',  'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('designations')->insert([ 'department_id'=> '2', 'designation_name' => 'Head of Accounts',  'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('designations')->insert([ 'department_id'=> '2', 'designation_name' => 'Accountant',  'created_at' => date('Y-m-d H:i:s') ]);

        DB::table('designations')->insert([ 'department_id'=> '3', 'designation_name' => 'GM, Sales & Marketing ',  'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('designations')->insert([ 'department_id'=> '3', 'designation_name' => 'DGM, Sales & Marketing ',  'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('designations')->insert([ 'department_id'=> '3', 'designation_name' => 'Manager Client Service',  'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('designations')->insert([ 'department_id'=> '3', 'designation_name' => 'Senior Executive',  'created_at' => date('Y-m-d H:i:s') ]);
    }
}
