<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear table and reset auto-increment (optional)
        DB::table('tms_menu')->truncate();

        // Insert parent menus
        DB::table('tms_menu')->insert([
            [
                'id' => 1,
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Dashboard',
                'tms_menu_route' => '/dashboard',
                'tms_menu_order' => 1,
                'tms_menu_package' => 'ADMIN,CUSTOMER,DRIVER',
                'tms_menu_parent' => 0,
                'tms_menu_status' => 1,
            ],
            [
                'id' => 2,
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Configuration',
                'tms_menu_route' => '/admin/configuration',
                'tms_menu_order' => 2,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 0,
                'tms_menu_status' => 1,
            ],
            [
                'id' => 3,
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Master',
                'tms_menu_route' => '/admin/master',
                'tms_menu_order' => 3,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 0,
                'tms_menu_status' => 1,
            ],
            [
                'id' => 4,
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Transactions',
                'tms_menu_route' => '/admin/transactions',
                'tms_menu_order' => 4,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 0,
                'tms_menu_status' => 1,
            ],
            [
                'id' => 5,
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Reports',
                'tms_menu_route' => '/admin/reports',
                'tms_menu_order' => 5,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 0,
                'tms_menu_status' => 1,
            ],
        ]);

        // Insert children for Configuration
        DB::table('tms_menu')->insert([
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Company',
                'tms_menu_route' => '/admin/company',
                'tms_menu_order' => 1,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 2,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Group Permissions',
                'tms_menu_route' => '/admin/group-permissions',
                'tms_menu_order' => 2,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 2,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'System Log',
                'tms_menu_route' => '/admin/system-log',
                'tms_menu_order' => 3,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 2,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Notification Hub',
                'tms_menu_route' => '/admin/notification-hub',
                'tms_menu_order' => 4,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 2,
                'tms_menu_status' => 1,
            ],
        ]);

        // Insert children for Master
        DB::table('tms_menu')->insert([
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Employee',
                'tms_menu_route' => '/admin/employee',
                'tms_menu_order' => 1,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 3,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Customer',
                'tms_menu_route' => '/admin/customer',
                'tms_menu_order' => 2,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 3,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Supplier',
                'tms_menu_route' => '/admin/supplier',
                'tms_menu_order' => 3,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 3,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Vehicle',
                'tms_menu_route' => '/vehicle',
                'tms_menu_order' => 4,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 3,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Vehicle Type',
                'tms_menu_route' => '/vehicle-type',
                'tms_menu_order' => 5,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 3,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Customer Rate Master',
                'tms_menu_route' => '/admin/customer-rate',
                'tms_menu_order' => 6,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 3,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Locations',
                'tms_menu_route' => '/locations',
                'tms_menu_order' => 7,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 3,
                'tms_menu_status' => 1,
            ],
        ]);

        // Insert children for Transactions
        DB::table('tms_menu')->insert([
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Shipment Create',
                'tms_menu_route' => '/create-shipment',
                'tms_menu_order' => 1,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 4,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Trip Invoice',
                'tms_menu_route' => '/invoice',
                'tms_menu_order' => 2,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 4,
                'tms_menu_status' => 1,
            ],
        ]);

        // Insert children for Reports
        DB::table('tms_menu')->insert([
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Customer Report',
                'tms_menu_route' => '/customer-report',
                'tms_menu_order' => 1,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 5,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'Supplier Report',
                'tms_menu_route' => '/supplier-report',
                'tms_menu_order' => 2,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 5,
                'tms_menu_status' => 1,
            ],
            [
                'tms_menu_icon' => 'no-icon',
                'tms_menu_name' => 'General Report',
                'tms_menu_route' => '/general-report',
                'tms_menu_order' => 3,
                'tms_menu_package' => 'ADMIN',
                'tms_menu_parent' => 5,
                'tms_menu_status' => 1,
            ],
        ]);
    }
}