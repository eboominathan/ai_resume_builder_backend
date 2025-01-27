<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['name' => 'DR Radhakrishnan Nagar', 'type' => 'street'],
            ['name' => 'Peedampalli', 'type' => 'area'],
            ['name' => 'Peedampalli', 'type' => 'village'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
