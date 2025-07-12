<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class ReportController extends Controller
{
    // Example: Get a report (customize as needed)
    public function index()
    {
        return response()->json([
            'status' => 200,
            'message' => 'Report endpoint is working.'
        ]);
    }

    public function sendtestmail(){
        Mail::raw('This is a test email via Mailjet!', function ($message) {
            $message->to('ravindulaksilu28@gmail.com')
                    ->subject('Test Mailjet Email');
        });
    }
    
}

