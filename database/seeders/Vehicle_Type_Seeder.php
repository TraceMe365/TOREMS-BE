<?php

namespace Database\Seeders;

use App\Models\VehicleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Vehicle_Type_Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleType::create([
            'veh_type' => '14.5FT',
            'veh_type_specification' => '14.5 Feet Truck',
            'veh_efficiency' => null,
            'veh_type_status' => 1,
            'created_by' => 1,
            'tms_com_id' => null,
            'tms_cus_id' => null,
            'veh_capacity' => null,
        ]);

        VehicleType::create([
            'veh_type' => '7FT',
            'veh_type_specification' => '7 Feet Truck',
            'veh_efficiency' => null,
            'veh_type_status' => 1,
            'created_by' => 1,
            'tms_com_id' => null,
            'tms_cus_id' => null,
            'veh_capacity' => null,
        ]);

        VehicleType::create([
            'veh_type' => '10.5FT',
            'veh_type_specification' => '10.5 Feet Truck',
            'veh_efficiency' => null,
            'veh_type_status' => 1,
            'created_by' => 1,
            'tms_com_id' => null,
            'tms_cus_id' => null,
            'veh_capacity' => null,
        ]);

        VehicleType::create([
            'veh_type' => '40FT',
            'veh_type_specification' => '40 Feet Container',
            'veh_efficiency' => null,
            'veh_type_status' => 1,
            'created_by' => 1,
            'tms_com_id' => null,
            'tms_cus_id' => null,
            'veh_capacity' => null,
        ]);
    }
}
