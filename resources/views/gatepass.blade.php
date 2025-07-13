<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gatepass</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 4px; }
        .header { text-align: center; }
        .section-title { font-weight: bold; margin-top: 10px; }
        .watermark {
            position: fixed;
            top: 35%;
            left: 50%;
            width: 400px;
            opacity: 0.08;
            transform: translate(-50%, -50%);
            z-index: 0;
        }
        .content {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    @if(!empty($company->image_path))
        <img src="{{ public_path($company->image_path) }}" class="watermark" alt="Company Watermark">
    @endif

    <div class="content">
        <div class="header">
            <div>Print Date: {{ now()->format('Y-m-d') }}</div>
            <div>Print Time: {{ now()->format('H:i:s') }}</div>
            <h3>{{ $company->company_name }}</h3>
            <div>{{ $company->address }}</div>
            <div>Tele: {{ $company->contact }} &nbsp; E-mail: {{ $company->email }}  &nbsp; Website:{{ $company->website }} </div>
            <div>LOG SHEET - Serial No | Request No {{ $shipment->tms_shp_request_no }}</div>
            <div style="text-align:right;"> {{$shipment->tms_is_gate_pass_print == 0 ? "Original" : "Print Count: ".$shipment->tms_is_gate_pass_print}} </div>
        </div>

        <div class="section-title">TRANSPORT REQUEST DETAILS</div>
        <table>
            <tr>
                <th>Request No</th>
                <td colspan="3">{{ $shipment->tms_shp_request_no }}</td>
            </tr>
            <tr>
                <th>Request Plant</th>
                <td colspan="3">{{ $shipment->pickupLocation->loc_name ?? '' }}</td>
            </tr>
            <tr>
                <th>Remarks</th>
                <td colspan="3">{{ $shipment->tms_shp_remarks ?? '' }}</td>
            </tr>
            <tr>
                <th>Created</th>
                <td colspan="3">{{ $shipment->created_at }}</td>
            </tr>
             <tr>
                <th>Customer</th>
                <td colspan="3">{{ $shipment->customer->cus_name }}</td>
            </tr>
        </table>

        <div class="section-title">VEHICLES AND EMPLOYEE DETAILS</div>
        <table>
            <tr>
                <th>Vehicle No</th>
                <td>{{ $shipment->vehicle->veh_no ?? '' }}</td>
                <th>Driver Name</th>
                <td>{{ ($shipment->driver->emp_f_name . " " . $shipment->driver->emp_s_name)  ?? $shipment->tms_shp_driver ?? '' }}</td>
            </tr>
            <tr>
                <th>Pickup Date & Time</th>
                <td>{{ $shipment->tms_shp_request_date }}</td>
                <th>Driver Contact</th>
                <td>{{ $shipment->driver->emp_mobile ?? '' }}</td>
            </tr>
        </table>

        <div class="section-title">LOCATIONS INFORMATION</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Location Name</th>
                    <th>Contact Person</th>
                    <th>Contact Number</th>
                    <th>Arrived At</th>
                    <th>Departed At</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>{{ $shipment->pickupLocation->loc_name ?? '' }}</td>
                    <td>{{ $shipment->pickupLocation->contact_person ?? '' }}</td>
                    <td>{{ $shipment->pickupLocation->contact ?? '' }}</td>
                    <td>{{ $shipment->tms_shp_arrived_pickup ?? '' }}</td>
                    <td>{{ $shipment->tms_shp_departed_pickup ?? '' }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>{{ $shipment->deliveryLocation->loc_name ?? '' }}</td>
                    <td>{{ $shipment->deliveryLocation->contact_person ?? '' }}</td>
                    <td>{{ $shipment->deliveryLocation->contact ?? '' }}</td>
                    <td>{{ $shipment->tms_shp_arrived_delivery ?? '' }}</td>
                    <td>{{ $shipment->tms_shp_departed_delivery ?? '' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>