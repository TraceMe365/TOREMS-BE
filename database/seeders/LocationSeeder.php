<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;
use Carbon\Carbon;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::create([
            'loc_id' => 3,
            'loc_code' => 'LOC003',
            'loc_name' => 'Colombo Main Warehouse',
            'loc_address' => 'Colombo 15, Orugodawatta',
            'loc_status' => 'ACTIVE',
            'loc_lat' => 6.9441737,
            'loc_long' => 79.8878122,
            'created_by' => 39,
            'loc_contact_person' => 'Sunil Fernando',
            'loc_contact_mobile' => '0112345678',
            'cus_id' => null,
            'loc_priority_level' => 1,
            'loc_distance' => 0,
            'loc_excess_calculate' => 0,
            'loc_loading_charge' => 0,
            'filled' => 0,
            'created_at' => Carbon::parse('2025-07-19 10:35:00'),
            'updated_at' => Carbon::parse('2025-07-19 10:35:00'),
        ]);

        Location::create([
            'loc_id' => 4,
            'loc_code' => 'LOC004',
            'loc_name' => 'Kandy Tea Center',
            'loc_address' => 'Kandy, Central Province',
            'loc_status' => 'ACTIVE',
            'loc_lat' => 7.2905715,
            'loc_long' => 80.6337262,
            'created_by' => 39,
            'loc_contact_person' => 'Mahinda Silva',
            'loc_contact_mobile' => '0812234567',
            'cus_id' => null,
            'loc_priority_level' => 2,
            'loc_distance' => 0,
            'loc_excess_calculate' => 0,
            'loc_loading_charge' => 0,
            'filled' => 0,
            'created_at' => Carbon::parse('2025-07-19 10:40:00'),
            'updated_at' => Carbon::parse('2025-07-19 10:40:00'),
        ]);

        Location::create([
            'loc_id' => 5,
            'loc_code' => 'LOC005',
            'loc_name' => 'Nuwara Eliya Estate',
            'loc_address' => 'Nuwara Eliya, Uva Province',
            'loc_status' => 'ACTIVE',
            'loc_lat' => 6.9497,
            'loc_long' => 80.7891,
            'created_by' => 39,
            'loc_contact_person' => 'Kumari Rajapaksha',
            'loc_contact_mobile' => '0522345678',
            'cus_id' => null,
            'loc_distance' => 0,
            'loc_excess_calculate' => 0,
            'loc_loading_charge' => 0,
            'filled' => 0,
            'created_at' => Carbon::parse('2025-07-19 10:45:00'),
            'updated_at' => Carbon::parse('2025-07-19 10:45:00'),
        ]);

        Location::create([
            'loc_id' => 6,
            'loc_code' => 'LOC006',
            'loc_name' => 'Galle Port Terminal',
            'loc_address' => 'Galle Harbour, Southern Province',
            'loc_status' => 'ACTIVE',
            'loc_lat' => 6.0329,
            'loc_long' => 80.2168,
            'created_by' => 39,
            'loc_contact_person' => 'Chaminda Wickramasinghe',
            'loc_contact_mobile' => '0912345678',
            'cus_id' => null,
            'loc_priority_level' => 3,
            'loc_distance' => 0,
            'loc_excess_calculate' => 0,
            'loc_loading_charge' => 0,
            'filled' => 0,
            'created_at' => Carbon::parse('2025-07-19 10:50:00'),
            'updated_at' => Carbon::parse('2025-07-19 10:50:00'),
        ]);

        Location::create([
            'loc_id' => 7,
            'loc_code' => 'LOC007',
            'loc_name' => 'Matara Distribution Center',
            'loc_address' => 'Matara, Southern Province',
            'loc_status' => 'INACTIVE',
            'loc_lat' => 5.9485,
            'loc_long' => 80.5353,
            'created_by' => 39,
            'loc_contact_person' => 'Ravi Gunasekara',
            'loc_contact_mobile' => '0412345678',
            'cus_id' => null,
            'loc_priority_level' => 0,
            'loc_distance' => 0,
            'loc_excess_calculate' => 0,
            'loc_loading_charge' => 0,
            'filled' => 0,
            'created_at' => Carbon::parse('2025-07-19 10:55:00'),
            'updated_at' => Carbon::parse('2025-07-19 10:55:00'),
        ]);
    }
}
