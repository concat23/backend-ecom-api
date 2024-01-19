<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EcomAccountTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $data = [
                ['id' => 1, 'account_type_name' => 'business', 'language' => 0],
                ['id' => 2, 'account_type_name' => 'normal', 'language' => 0],
            ];

            // Insert data into the mtb_account_type table
            DB::table('ecom_account_types')->insert($data);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }
}
