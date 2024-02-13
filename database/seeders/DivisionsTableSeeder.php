<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('divisions')->insert([ 'division_name' => 'Barishal' ]);
        DB::table('divisions')->insert([ 'division_name' => 'Chattogram' ]);
        DB::table('divisions')->insert([ 'division_name' => 'Dhaka' ]);
        DB::table('divisions')->insert([ 'division_name' => 'Khulna' ]);
        DB::table('divisions')->insert([ 'division_name' => 'Mymensingh' ]);
        DB::table('divisions')->insert([ 'division_name' => 'Rajshahi' ]);
        DB::table('divisions')->insert([ 'division_name' => 'Rangpur' ]);
        DB::table('divisions')->insert([ 'division_name' => 'Sylhet' ]);
    }
}
