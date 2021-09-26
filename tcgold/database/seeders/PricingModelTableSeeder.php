<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pricing_model')->insert([
            'start_date' => date('Y-m-d H:i:s'),
            'by_weight' => '5',
            'by_volume' => '1000',
            'by_value' => '3',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
