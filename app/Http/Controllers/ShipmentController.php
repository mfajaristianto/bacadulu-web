<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;

class ShipmentController extends Controller
{
    // Menampilkan halaman form cek resi
    public function index()
    {
        return view('landing-page.pages.cek-resi');
    }

    // Proses pencarian resi berdasarkan input user
    public function track(Request $request)
    {
        $request->validate([
            'resi_number' => 'required|string',
        ]);

        // Cari resi di database
        $shipment = Shipment::where('resi_number', $request->resi_number)->first();

        // Jika resi tidak ditemukan
        if (!$shipment) {
            return back()->with('error', 'Nomor resi "' . $request->resi_number . '" tidak ditemukan. Periksa kembali nomor resi Anda.');
        }

        // Jika ketemu, tampilkan halaman hasil tracking
        return view('landing-page.pages.cek-resi', compact('shipment'));
    }
}