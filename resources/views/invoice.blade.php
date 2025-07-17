<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $invoice->tms_inv_no }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 10px; }
        th, td { border: 1px solid #000; padding: 4px; }
        .header { text-align: center; }
        .section-title { font-weight: bold; margin-top: 10px; }
        .right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>INVOICE</h2>
        <div>{{ $company->company_name ?? '' }}</div>
        <div>{{ $company->address ?? '' }}</div>
        <div>Tel: {{ $company->contact ?? '' }} | Email: {{ $company->email ?? '' }}</div>
    </div>

    <div class="section-title">Invoice Details</div>
    <table>
        <tr>
            <th>Invoice No</th>
            <td>{{ $invoice->tms_inv_no }}</td>
            <th>Date</th>
            <td>{{ $invoice->tms_inv_date }}</td>
        </tr>
        <tr>
            <th>Customer</th>
            <td colspan="3">{{ $invoice->customer->cus_name ?? '' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $invoice->tms_inv_status }}</td>
            <th>Mode</th>
            <td>{{ $invoice->tms_inv_mode }}</td>
        </tr>
    </table>

    <div class="section-title">Invoice Entries</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Shipment ID</th>
                <th>Delivery</th>
                <th>Loading</th>
                <th>Demurrage</th>
                <th>Night Bata</th>
                <th>Other</th>
                <th>Deductions</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->entries as $i => $entry)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $entry->shipment->tms_shp_request_no }}</td>
                <td class="right">{{ number_format($entry->tms_ien_delivery, 2) }}</td>
                <td class="right">{{ number_format($entry->tms_ien_loading, 2) }}</td>
                <td class="right">{{ number_format($entry->tms_ien_demurrage, 2) }}</td>
                <td class="right">{{ number_format($entry->tms_ien_night_bata, 2) }}</td>
                <td class="right">{{ number_format($entry->tms_ien_other, 2) }}</td>
                <td class="right">{{ number_format($entry->tms_ien_deduction, 2) }}</td>
                <td class="right">{{ number_format(
               ($entry->tms_ien_delivery ?? 0) +
                    ($entry->tms_ien_loading ?? 0) +
                    ($entry->tms_ien_demurrage ?? 0) +
                    ($entry->tms_ien_night_bata ?? 0) +
                    ($entry->tms_ien_other ?? 0) -
                    ($entry->tms_ien_deduction ?? 0), 2) }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Totals</div>
    <table>
        <tr>
            <th>Net Amount</th>
            <td class="right" colspan="3"><strong>{{
                number_format(
               ($entry->tms_ien_delivery ?? 0) +
                    ($entry->tms_ien_loading ?? 0) +
                    ($entry->tms_ien_demurrage ?? 0) +
                    ($entry->tms_ien_night_bata ?? 0) +
                    ($entry->tms_ien_other ?? 0) -
                    ($entry->tms_ien_deduction ?? 0), 2)
            }}</strong></td>
        </tr>
    </table>

    <div style="margin-top:40px;">
        <div>Prepared By: ____________________</div>
        <div>Authorized By: __________________</div>