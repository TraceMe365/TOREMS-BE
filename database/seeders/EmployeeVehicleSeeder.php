<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Vehicle;

class EmployeeVehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed Employees (Drivers)
        $driver1 = Employee::create([
            'emp_f_name' => 'Prasanga',
            'emp_s_name' => 'De Silva',
            'emp_mobile' => '0771234567',
            'emp_type' => 'driver',
            'emp_status' => 1,
            'emp_address' => 'Colombo',
            'created_by' => 1,
        ]);

        $driver2 = Employee::create([
            'emp_f_name' => 'Kasun',
            'emp_s_name' => 'Siriwardana',
            'emp_mobile' => '0777654321',
            'emp_type' => 'driver',
            'emp_status' => 1,
            'emp_address' => 'Kandy',
            'created_by' => 1,
        ]);

        $driver3 = Employee::create([
            'emp_f_name' => 'Jeewan',
            'emp_s_name' => 'Gunasekara',
            'emp_mobile' => '0712345678',
            'emp_type' => 'driver',
            'emp_status' => 1,
            'emp_address' => 'Galle',
            'created_by' => 1,
        ]);

        // Seed Vehicles
        Vehicle::create([
            'veh_no' => 'WP-LB-1234',
            'vehicle_type' => 1,
            'veh_loading_capacity' => 2000,
            'veh_status' => 1,
            'veh_availability' => 1,
            'veh_diver_id' => $driver1->emp_id,
            'created_by' => 1,
        ]);

        Vehicle::create([
            'veh_no' => 'WP-LD-5678',
            'vehicle_type' => 2,
            'veh_loading_capacity' => 1500,
            'veh_status' => 1,
            'veh_availability' => 1,
            'veh_diver_id' => $driver2->emp_id,
            'created_by' => 1,
        ]);

        Vehicle::create([
            'veh_no' => 'WP-LF-9012',
            'vehicle_type' => 1,
            'veh_loading_capacity' => 2500,
            'veh_status' => 1,
            'veh_availability' => 1,
            'veh_diver_id' => $driver3->emp_id,
            'created_by' => 1,
        ]);
    }
}
