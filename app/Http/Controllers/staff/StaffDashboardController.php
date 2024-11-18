<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Controller;

class StaffDashboardController extends Controller
{
    public function index()
    {
        return view('staff.dashboard.index');
    }
}