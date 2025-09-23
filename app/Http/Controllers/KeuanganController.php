<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.keuangan.index', [
            'title' => 'Dashboard Administrasi',
        ]);
    }
}
