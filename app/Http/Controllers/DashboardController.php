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

    public function dashboardEmployee(Request $request)
    {
        $user = auth()->user(); // Assuming you use Laravel Auth for employees

        // Total shipments and mileage for this driver/employee
        $totalShipments = Shipment::where('tms_shp_driver', $user->emp_id)->count();
        $totalMileage   = Shipment::where('tms_shp_driver', $user->emp_id)->sum('tms_shp_estimated_mileage');

        // Shipments per month (current year)
        $shipmentsPerMonth = Shipment::select(
                DB::raw('MONTH(tms_shp_request_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('tms_shp_driver', $user->emp_id)
            ->whereYear('tms_shp_request_date', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(tms_shp_request_date)'))
            ->orderBy('month')
            ->get();

        $labels = [];
        $shipmentsData = [];
        for ($m = 1; $m <= 12; $m++) {
            $labels[] = Carbon::create()->month($m)->format('M');
            $found = $shipmentsPerMonth->firstWhere('month', $m);
            $shipmentsData[] = $found ? (int)$found->count : 0;
        }

        // Completed vs Pending Shipments
        $completed = Shipment::where('tms_shp_driver', $user->emp_id)
            ->where('tms_shp_status', 'Complete')->count();
        $pending = Shipment::where('tms_shp_driver', $user->emp_id)
            ->where('tms_shp_status', 'Pending')->count();

        return response()->json([
            'totalShipments' => $totalShipments,
            'totalMileage'   => $totalMileage,
            'tripsPerMonthData' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Shipments',
                        'data' => $shipmentsData,
                        'backgroundColor' => '#60a5fa',
                        'borderColor' => '#2563eb',
                        'borderWidth' => 2,
                        'tension' => 0.4,
                    ]
                ]
            ],
            'tripStatusData' => [
                'labels' => ['Completed', 'Pending'],
                'datasets' => [
                    [
                        'label' => 'Shipments',
                        'data' => [$completed, $pending],
                        'backgroundColor' => ['#22c55e', '#fbbf24'],
                    ]
                ]
            ]
        ]);
    }

    public function dashboardCustomer(Request $request)
    {
        $user = auth()->user(); // Assuming the customer is authenticated

        // Get the customer ID (adjust if your user model is different)
        $customerId = $user->customer_id;

        // Jobs per month (current year)
        $jobsPerMonth = Shipment::select(
                DB::raw('MONTH(tms_shp_request_date) as month'),
                DB::raw('COUNT(*) as count')
            )
            ->where('tms_cus_id', $customerId)
            ->whereYear('tms_shp_request_date', Carbon::now()->year)
            ->groupBy(DB::raw('MONTH(tms_shp_request_date)'))
            ->orderBy('month')
            ->get();

        $labels = [];
        $jobsData = [];
        for ($m = 1; $m <= 12; $m++) {
            $labels[] = Carbon::create()->month($m)->format('M');
            $found = $jobsPerMonth->firstWhere('month', $m);
            $jobsData[] = $found ? (int)$found->count : 0;
        }

        // Shipment Status Data (Pending, Ongoing, Completed, Invoiced)
        $statusOrder = ['Pending', 'Ongoing', 'Completed', 'Invoiced'];
        $statusCountsRaw = Shipment::where('tms_cus_id', $customerId)
            ->select('tms_shp_status', DB::raw('COUNT(*) as count'))
            ->groupBy('tms_shp_status')
            ->pluck('count', 'tms_shp_status')
            ->toArray();

        $shipmentStatusData = [];
        foreach ($statusOrder as $status) {
            $shipmentStatusData[] = isset($statusCountsRaw[$status]) ? (int)$statusCountsRaw[$status] : 0;
        }

        // Invoice Summary Data (Unpaid, Paid, Overdue)
        $invoiceStatusOrder = ['Unpaid', 'Paid', 'Overdue'];
        $invoiceCountsRaw = \App\Models\Invoice::where('tms_cus_id', $customerId)
            ->select('tms_inv_status', DB::raw('COUNT(*) as count'))
            ->groupBy('tms_inv_status')
            ->pluck('count', 'tms_inv_status')
            ->toArray();

        $invoiceSummaryData = [];
        foreach ($invoiceStatusOrder as $status) {
            $invoiceSummaryData[] = isset($invoiceCountsRaw[$status]) ? (int)$invoiceCountsRaw[$status] : 0;
        }

        // Recent Shipments (limit 10)
        $shipments = Shipment::with(['pickupLocation', 'deliveryLocation'])
            ->where('tms_cus_id', $customerId)
            ->orderBy('tms_shp_request_date', 'desc')
            ->limit(10)
            ->get(
                ['tms_shp_id', 'tms_shp_request_no', 'tms_shp_status', 'tms_shp_pickup_loc', 'tms_shp_delivery_loc']
            );

        $shipmentsArr = [];
        foreach ($shipments as $shp) {
            $shipmentsArr[] = [
                'tms_shp_id'        => $shp->tms_shp_id,
                'tms_shp_request_no'=> $shp->tms_shp_request_no,
                'tms_shp_status'    => $shp->tms_shp_status,
                'pickup_location'   => ['loc_name' => $shp->pickupLocation->loc_name ?? ''],
                'delivery_location' => ['loc_name' => $shp->deliveryLocation->loc_name ?? ''],
            ];
        }

        return response()->json([
            'jobsLineData' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Total Jobs',
                        'data' => $jobsData,
                        'fill' => false,
                        'borderColor' => '#4caf50',
                        'backgroundColor' => '#4caf50',
                        'tension' => 0.3,
                        'pointRadius' => 4,
                        'pointBackgroundColor' => '#4caf50',
                    ],
                ],
            ],
            'shipmentStatusData' => [
                'labels' => $statusOrder,
                'datasets' => [
                    [
                        'label' => 'Shipment Status',
                        'data' => $shipmentStatusData,
                        'backgroundColor' => ['#ff9800', '#4caf50', '#2196f3', '#9c27b0'],
                    ],
                ],
            ],
            'invoiceSummaryData' => [
                'labels' => $invoiceStatusOrder,
                'datasets' => [
                    [
                        'label' => 'Invoice Summary',
                        'data' => $invoiceSummaryData,
                        'backgroundColor' => ['#f44336', '#4caf50', '#ff9800'],
                    ],
                ],
            ],
            'shipments' => $shipmentsArr,
            'user'=>$user
        ]);
    }
}
