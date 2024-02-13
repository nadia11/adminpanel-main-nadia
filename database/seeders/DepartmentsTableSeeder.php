<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([ 'department_name' => 'Administration Department',     'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('departments')->insert([ 'department_name' => 'Accounts Department',           'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('departments')->insert([ 'department_name' => 'Sales & Marketing Department',  'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('departments')->insert([ 'department_name' => 'Design Department',             'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('departments')->insert([ 'department_name' => 'Outdoor Department',            'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('departments')->insert([ 'department_name' => 'Product Department',            'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('departments')->insert([ 'department_name' => 'Printing Department',           'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('departments')->insert([ 'department_name' => 'Electrical Section',            'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('departments')->insert([ 'department_name' => 'Carpenting Section',            'created_at' => date('Y-m-d H:i:s') ]);
        DB::table('departments')->insert([ 'department_name' => 'Welding Section',               'created_at' => date('Y-m-d H:i:s') ]);
    }
}
