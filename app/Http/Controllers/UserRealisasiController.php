<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use App\Models\Opd;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRealisasiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data untuk Dropdown Filter
        $listOpd = Opd::orderBy('nama_opd', 'asc')->get();
        $listTahun = Tahun::orderBy('tahun', 'desc')->get();

        // 2. Base Query dengan Join
        $query = Realisasi::query()
            ->join('tahun', 'realisasi.id_tahun', '=', 'tahun.id')
            ->join('opd', 'realisasi.id_opd', '=', 'opd.id')
            ->select('realisasi.*', 'tahun.tahun as label_tahun', 'opd.nama_opd');

        // 3. Logika Filter
        if ($request->filled('tahun')) {
            $query->where('tahun.tahun', $request->tahun);
        }
        if ($request->filled('opd')) {
            $query->where('opd.nama_opd', $request->opd);
        }

        // 4. Statistik Atas (Samakan dengan RKPD)
        $totalAnggaran = (clone $query)->sum('realisasi.anggaran');
        $jumlahProgram = (clone $query)->distinct('realisasi.program')->count('realisasi.program');
        $jumlahKegiatan = (clone $query)->distinct('realisasi.kegiatan')->count('realisasi.kegiatan');

        // 5. Data Visualisasi (Ukuran disamakan dengan RKPD)
        $dataProgram = (clone $query)->select('realisasi.program', DB::raw('SUM(realisasi.anggaran) as total'))
            ->groupBy('realisasi.program')->get();

        $dataTahunTrend = Realisasi::join('tahun', 'realisasi.id_tahun', '=', 'tahun.id')
            ->select('tahun.tahun as label_thn', DB::raw('SUM(realisasi.anggaran) as total'))
            ->when($request->opd, function($q) use ($request) {
                return $q->whereExists(function($sub) use ($request) {
                    $sub->select(DB::raw(1))->from('opd')->whereColumn('opd.id', 'realisasi.id_opd')->where('nama_opd', $request->opd);
                });
            })
            ->groupBy('tahun.tahun')->orderBy('tahun.tahun', 'asc')->get();

        $dataOpd = (clone $query)->select('opd.nama_opd', DB::raw('SUM(realisasi.anggaran) as total'))
            ->groupBy('opd.nama_opd')->get();

        // 6. Rincian Data
        $rincianData = $query->with(['tahun', 'opd'])->get();

        return view('user.realisasi.index', compact(
            'listOpd', 'listTahun', 'dataProgram', 
            'dataTahunTrend', 'dataOpd', 'rincianData', 
            'totalAnggaran', 'jumlahProgram', 'jumlahKegiatan'
        ));
    }
}