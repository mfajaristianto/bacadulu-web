<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use App\Models\Jurnal;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $informationCount = Information::count();
        $jurnalCount = Jurnal::count();

        return view('admin.dashboard', compact('informationCount', 'jurnalCount'));
    }
}
