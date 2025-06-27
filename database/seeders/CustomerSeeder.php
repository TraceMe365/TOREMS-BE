<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'cus_code' => 'CUST001',
            'cus_name' => 'Alpha Trading',
            'cus_address' => '123 Main Street, Colombo',
            'cus_con_person' => 'John Doe',
            'cus_con_person_num' => '0771234567',
            'cus_con_person_email' => 'john@alpha.com',
            'cus_other_details' => 'Preferred customer',
            'cus_status' => 1,
            'created_by' => 1,
            'tms_package' => 'Standard',
            'tms_com_id' => 1,
            'start_loc_type' => 'Warehouse',
            'end_loc_type' => 'Showroom',
            'aditional_mileage_pre' => 0,
            'cus_vat_number' => 'VAT123456',
            'cus_nbt_number' => 'NBT123456',
        ]);

        Customer::create([
            'cus_code' => 'CUST002',
            'cus_name' => 'Beta Logistics',
            'cus_address' => '456 Second Lane, Kandy',
            'cus_con_person' => 'Jane Smith',
            'cus_con_person_num' => '0777654321',
            'cus_con_person_email' => 'jane@beta.com',
            'cus_other_details' => 'Handles fragile goods',
            'cus_status' => 1,
            'created_by' => 1,
            'tms_package' => 'Premium',
            'tms_com_id' => 1,
            'start_loc_type' => 'Factory',
            'end_loc_type' => 'Warehouse',
            'aditional_mileage_pre' => 5,
            'cus_vat_number' => 'VAT654321',
            'cus_nbt_number' => 'NBT654321',
        ]);

        Customer::create([
            'cus_code' => 'CUST003',
            'cus_name' => 'Gamma Supplies',
            'cus_address' => '789 Third Avenue, Galle',
            'cus_con_person' => 'Michael Lee',
            'cus_con_person_num' => '0712345678',
            'cus_con_person_email' => 'michael@gamma.com',
            'cus_other_details' => 'Bulk orders',
            'cus_status' => 1,
            'created_by' => 1,
            'tms_package' => 'Basic',
            'tms_com_id' => 1,
            'start_loc_type' => 'Showroom',
            'end_loc_type' => 'Customer',
            'aditional_mileage_pre' => 2,
            'cus_vat_number' => 'VAT789123',
            'cus_nbt_number' => 'NBT789123',
        ]);
    }
}
