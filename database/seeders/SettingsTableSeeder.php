<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            'company_name' => 'Esojai Limited',
            'logo' => '',
            'company_phone' => '+8801976355569',
            'company_email' => 'esojai2020@gmail.com',
            'currency' => 'BDT',
            'keyboard' => 1,
            'decimals' => '1',
            'timezone' => 'Asia/Dhaka',
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }
}
