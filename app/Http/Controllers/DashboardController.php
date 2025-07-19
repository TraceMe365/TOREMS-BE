<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Shipment;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardAdmin(Request $request)
    {
        // Total Customers
        $totalCustomers = Customer::count();

        // Total Jobs (Shipments)
        $totalJobs = Shipment::count();

        // Total Mileage (sum of all shipment mileage)
        $totalMileage = Shipment::sum('tms_shp_estimated_mileage');

        // Shipment Trend (monthly count for current year)
        $trend = Shipment::select(
                DB::raw('MONTH(tms_shp_request_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereYear('tms_shp_request_date', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(tms_shp_request_date)'))
            ->orderBy('month')
            ->get();

        // Shipment Status Pie (ensure order and fill missing)
        $statusOrder = ['Complete', 'In Progress', 'Pending', 'Cancelled'];
        $statusCountsRaw = Shipment::select('tms_shp_status', DB::raw('COUNT(*) as count'))
            ->groupBy('tms_shp_status')
            ->pluck('count', 'tms_shp_status')
            ->toArray();

        $shipmentStatus = [];
        foreach ($statusOrder as $status) {
            $shipmentStatus[] = isset($statusCountsRaw[$status]) ? (int)$statusCountsRaw[$status] : 0;
        }

        // Mileage Trend (monthly sum for current year)
        $mileageTrendRaw = Shipment::select(
                DB::raw('MONTH(tms_shp_request_date) as month'),
                DB::raw('SUM(tms_shp_estimated_mileage) as mileage')
            )
            ->whereYear('tms_shp_request_date', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(tms_shp_request_date)'))
            ->orderBy('month')
            ->get();

        $mileageLabels = [];
        $mileageValues = [];
        foreach ($mileageTrendRaw as $row) {
            $mileageLabels[] = Carbon::create()->month($row->month)->format('M');
            $mileageValues[] = (float)$row->mileage;
        }

        return response()->json([
            'total_customers' => $totalCustomers,
            'total_jobs'      => $totalJobs,
            'total_mileage'   => $totalMileage,
            'shipment_status' => $shipmentStatus,
            'mileage_trend'   => [
                'labels' => $mileageLabels,
                'values' => $mileageValues,
            ],
        ]);

    }
}
