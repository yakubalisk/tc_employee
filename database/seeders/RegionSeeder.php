<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            ['name' => 'MUMBAI', 'code' => 'MUM', 'description' => 'Mumbai Region'],
            ['name' => 'BANGALORE', 'code' => 'BNG', 'description' => 'Bangalore Region'],
            ['name' => 'AHMEDABAD', 'code' => 'AHD', 'description' => 'Ahmedabad Region'],
            ['name' => 'JAIPUR', 'code' => 'JPR', 'description' => 'Jaipur Region'],
            ['name' => 'NEW DELHI - NARAINA', 'code' => 'DEL', 'description' => 'New Delhi Naraina Region'],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}