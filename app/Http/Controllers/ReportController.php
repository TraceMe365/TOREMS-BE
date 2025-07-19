<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Quotation;
use App\Models\Shipment;
use App\Models\Vehicle;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ReportController extends Controller
{
    
    public function customerReport(Request $request)
    {
        try {
            $request->validate([
                'customer_id' => 'nullable|integer',
                'from'        => 'required|date',
                'to'          => 'required|date|after_or_equal:from',
            ]);

            DB::enableQueryLog();
            if($request->customer_id) {
                $query = Shipment::with(['customer', 'vehicle', 'driver', 'pickupLocation', 'deliveryLocation'])
                    ->where('tms_cus_id', $request->customer_id)
                    ->whereBetween('tms_shp_request_date', [$request->from, $request->to])
                    ->get();
            } else {
                $query = Shipment::with(['customer', 'vehicle', 'driver', 'pickupLocation', 'deliveryLocation'])
                    ->whereBetween('tms_shp_request_date', [$request->from, $request->to])
                    ->get();
            }
            
            $data = [];
            foreach($query as $que){
                if($que->quotation_id!=null){
                    $quotation = Quotation::find($que->quotation_id);
                }
                else{
                    $quotation = null;
                }
                $data[] = [
                    'shipment_id'       => $que->tms_shp_id,
                    'request_no'        => $que->tms_shp_request_no,
                    'customer_name'     => $que->customer->cus_name,
                    'vehicle'           => $que->vehicle->veh_no ?? "N/A",
                    'driver'            => $que->driver ? ($que->driver->emp_f_name . ' ' . $que->driver->emp_s_name) : "N/A",
                    'pickup_location'   => $que->pickupLocation->loc_name,
                    'delivery_location' => $que->deliveryLocation->loc_name,
                    'request_date'      => $que->tms_shp_request_date,
                    'quotation'         => $quotation->quotation_no ?? "N/A",
                    'status'            => $que->tms_shp_status
                ];
            }

            // Logic for generating customer report
            return response()->json([
                'status'  => 200,
                // 'query'   => DB::getQueryLog(),
                'data'    => $data,
                'message' => 'Customer report generated successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while generating the report.',
                'error' => $th->getMessage()
            ]);
        }
    }


    public function shipmentReport(Request $request)
    {
        try {
            $request->validate([
            'customer_id' => 'nullable|integer',
            'from'        => 'required|date',
            'to'          => 'required|date|after_or_equal:start_date',
            ]);

            DB::enableQueryLog();
            if($request->customer_id) {
                $query = Shipment::with(['customer', 'vehicle', 'driver', 'pickupLocation', 'deliveryLocation'])
                    ->where('tms_cus_id', $request->customer_id)
                    ->whereBetween('tms_shp_request_date', [$request->from, $request->to])
                    ->get();
            } else {
                $query = Shipment::with(['customer', 'vehicle', 'driver', 'pickupLocation', 'deliveryLocation'])
                    ->whereBetween('tms_shp_request_date', [$request->from, $request->to])
                    ->get();
            }

            // Logic for generating customer report
            return response()->json([
                'status'  => 200,
                // 'query'   => DB::getQueryLog(),
                'data'    => $query,
                'message' => 'Shipment report generated successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while generating the report.',
                'error' => $th->getMessage()
            ]);
        }
    }

    public function driverReport(Request $request)
    {
        try {
            $request->validate([
                'driver_id' => 'nullable|integer',
                'from'      => 'required|date',
                'to'        => 'required|date|after_or_equal:start_date',
            ]);

            DB::enableQueryLog();
            $data = [];
            if($request->driver_id){
                $employee = Employee::where('emp_id', $request->driver_id)->firstOrFail();
                $shipments = Shipment::with(['customer', 'vehicle', 'driver', 'pickupLocation', 'deliveryLocation'])
                    ->where('tms_shp_driver', $request->driver_id)
                    ->whereBetween('tms_shp_request_date', [$request->from, $request->to])
                    ->get();
                
                $totalShipments = $shipments->count();
                $totalMileage   = $shipments->sum('tms_shp_estimated_mileage');
                $totalDuration = 0;
                $shipmentNumbers = [];
                foreach($shipments as $shipment) {
                    if($shipment->tms_shp_shipment_start && $shipment->tms_shp_shipment_end) {
                        $startTime = \Carbon\Carbon::parse($shipment->tms_shp_shipment_start);
                        $endTime = \Carbon\Carbon::parse($shipment->tms_shp_shipment_end);
                        $totalDuration += $endTime->diffInMinutes($startTime);
                    }
                    $shipmentNumbers[] = $shipment->tms_shp_request_no;
                }

                $data = [
                    'driver_id'       => $employee->emp_id,
                    'driver_name'     => $employee->emp_f_name . ' ' . $employee->emp_s_name,
                    'total_shipments' => $totalShipments,
                    'total_mileage'   => $totalMileage,
                    'total_duration'  => $totalDuration,
                    'shipments'       => $shipmentNumbers,
                ];
                
            }
            else{
                // All drivers summary
                $drivers = Employee::where('emp_type', 'driver')->get();
                foreach ($drivers as $employee) {
                    $shipments = Shipment::with(['customer', 'vehicle', 'driver', 'pickupLocation', 'deliveryLocation'])
                        ->where('tms_shp_driver', $employee->emp_id)
                        ->whereBetween('tms_shp_request_date', [$request->from, $request->to])
                        ->get();

                    $totalShipments = $shipments->count();
                    $totalMileage   = $shipments->sum('tms_shp_estimated_mileage');
                    $totalDuration = 0;
                    $shipmentNumbers = [];
                    foreach ($shipments as $shipment) {
                        if ($shipment->tms_shp_shipment_start && $shipment->tms_shp_shipment_end) {
                            $startTime = \Carbon\Carbon::parse($shipment->tms_shp_shipment_start);
                            $endTime = \Carbon\Carbon::parse($shipment->tms_shp_shipment_end);
                            $totalDuration += $endTime->diffInMinutes($startTime);
                        }
                        $shipmentNumbers[] = $shipment->tms_shp_request_no;
                    }

                    $data[] = [
                        'driver_id'       => $employee->emp_id,
                        'driver_name'     => $employee->emp_f_name . ' ' . $employee->emp_s_name,
                        'total_shipments' => $totalShipments,
                        'total_mileage'   => $totalMileage,
                        'total_duration'  => $totalDuration,
                        'shipments'       => $shipmentNumbers,
                    ];
                }
            }

            // Logic for generating customer report
            return response()->json([
                'status'  => 200,
                // 'query'   => DB::getQueryLog(),
                'data'    => $data,
                'message' => 'Driver report generated successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while generating the report.',
                'error' => $th->getMessage()
            ]);
        }
    }


    public function mileageReport(Request $request)
    {
        try {
            $request->validate([
                'vehicle_id' => 'nullable|integer',
                'from'      => 'required|date',
                'to'        => 'required|date|after_or_equal:start_date',
            ]);

            DB::enableQueryLog();

            $data = [];

            if ($request->vehicle_id) {
                // Single vehicle
                $vehicle = Vehicle::with(['vehicle_type'])->findOrFail($request->vehicle_id);
                $shipments = Shipment::with(['customer', 'driver', 'pickupLocation', 'deliveryLocation'])
                    ->where('tms_veh_id', $vehicle->veh_id)
                    ->whereBetween('tms_shp_request_date', [$request->from, $request->to])
                    ->get();

                $totalMileage = $shipments->sum('tms_shp_estimated_mileage');

                $data = [
                    'vehicle_id'      => $vehicle->veh_id,
                    'vehicle_no'      => $vehicle->veh_no,
                    'total_mileage'   => $totalMileage,
                    'shipments'       => $shipments->pluck('tms_shp_request_no'),
                    'total_shipments' => $shipments->count(),
                ];
            } else {
                // All vehicles
                $vehicles = Vehicle::with(['vehicle_type'])->get();
                foreach ($vehicles as $vehicle) {
                    $shipments = Shipment::with(['customer', 'driver', 'pickupLocation', 'deliveryLocation'])
                        ->where('tms_veh_id', $vehicle->veh_id)
                        ->whereBetween('tms_shp_request_date', [$request->from, $request->to])
                        ->get();

                    $totalMileage = $shipments->sum('tms_shp_estimated_mileage');

                    $data[] = [
                        'vehicle_id'      => $vehicle->veh_id,
                        'vehicle_no'      => $vehicle->veh_no,
                        'total_mileage'   => $totalMileage,
                        'shipments'       => $shipments->pluck('tms_shp_request_no'),
                        'total_shipments' => $shipments->count(),
                    ];
                }
            }

            // Logic for generating customer report
            return response()->json([
                'status'  => 200,
                // 'query'   => DB::getQueryLog(),
                'data'    => $data,
                'message' => 'Mileage report generated successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while generating the report.',
                'error' => $th->getMessage()
            ]);
        }
    }


    public function costReport(Request $request)
    {
        try {
            $request->validate([
                'customer_id' => 'nullable|integer',
                'from'        => 'required|date',
                'to'          => 'required|date|after_or_equal:start_date',
            ]);

            DB::enableQueryLog();
            $query = Shipment::with(['customer','vehicle','driver','pickupLocation','deliveryLocation'])
                ->where('tms_cus_id', $request->customer_id)
                ->whereBetween('tms_shp_request_date', [$request->from, $request->to])
                ->get();

            // Logic for generating customer report
            return response()->json([
                'status'  => 200,
                // 'query'   => DB::getQueryLog(),
                'data'    => $query,
                'message' => 'Cost report generated successfully.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 500,
                'message' => 'An error occurred while generating the report.',
                'error' => $th->getMessage()
            ]);
        }
    }






    // public function sendtestmail(){
    //     Mail::raw('This is a test email via Mailjet API!', function ($message) {
    //         $message->to('ravindulaksilu28@gmail.com')
    //                 ->subject('Test Mailjet Email');
    //     });
    // }
    
}

