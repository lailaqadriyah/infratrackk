<?php

namespace App\Http\Controllers;

use App\Models\Renja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRenjaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Statistik Ringkasan
        $totalAnggaran = Renja::sum('anggaran');
        $jumlahProgram = Renja::distinct('program')->count('program');
        $jumlahKegiatan = Renja::count();

        // Data untuk Grafik (Doughnut & Bar)
        $chartData = Renja::select('program', DB::raw('SUM(anggaran) as total'))
            ->groupBy('program')
            ->get();

        $barData = Renja::orderBy('anggaran', 'desc')->take(5)->get();

        // Logika Ekstraksi Satuan Target
        $allTargets = Renja::pluck('target');
        $unitCounts = [];
        foreach ($allTargets as $t) {
            if ($t) {
                $parts = explode(' ', trim($t));
                $unit = ucfirst(strtolower(end($parts)));
                $unitCounts[$unit] = ($unitCounts[$unit] ?? 0) + 1;
            }
        }
        arsort($unitCounts);
        $targetUnitLabels = array_keys(array_slice($unitCounts, 0, 5));
        $targetUnitValues = array_values(array_slice($unitCounts, 0, 5));

        // --- INI BAGIAN DETAIL TABEL ---
        // Kita ambil semua data agar bisa dijabarkan satu-satu di view
        $allRenja = Renja::select('program', 'kegiatan', 'sub_kegiatan', 'indikator', 'target', 'anggaran')->get();

        return view('user.renja.index', compact(
            'totalAnggaran', 
            'jumlahProgram', 
            'jumlahKegiatan', 
            'chartData', 
            'barData', 
            'targetUnitLabels', 
            'targetUnitValues',
            'allRenja'
        ));
    }
}