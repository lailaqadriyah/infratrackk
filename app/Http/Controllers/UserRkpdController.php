<?php

namespace App\Http\Controllers;

use App\Models\Rkpd;
use App\Models\Opd;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRkpdController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data untuk Dropdown Filter
        $listOpd = Opd::orderBy('nama_opd', 'asc')->get();
        $listTahun = Tahun::orderBy('tahun', 'desc')->get();

        // 2. Base Query dengan Join ke tabel Tahun dan OPD
        $query = Rkpd::query()
            ->join('tahun', 'rkpd.id_tahun', '=', 'tahun.id')
            ->join('opd', 'rkpd.id_opd', '=', 'opd.id')
            ->select(
                'rkpd.*', 
                'tahun.tahun as label_tahun', 
                'opd.nama_opd'
            );

        // 3. Logika Filter
        if ($request->filled('tahun')) {
            $query->where('tahun.tahun', $request->tahun);
        }
        if ($request->filled('opd')) {
            $query->where('opd.nama_opd', $request->opd);
        }

        // 4. Statistik Atas (Mengikuti Filter)
        $totalAnggaran = (clone $query)->sum('rkpd.anggaran');
        $jumlahProgram = (clone $query)->distinct('rkpd.program')->count('rkpd.program');
        $jumlahKegiatan = (clone $query)->distinct('rkpd.kegiatan')->count('rkpd.kegiatan');

        // 5. Data Chart 1: Perbandingan Anggaran Per Program (Pie)
        $dataProgram = (clone $query)->select('rkpd.program', DB::raw('SUM(rkpd.anggaran) as total'))
            ->groupBy('rkpd.program')->get();

        // 6. Data Chart 2: Tren Anggaran Per Tahun (Line)
        // Note: Untuk tren tahunan, kita hilangkan filter tahun agar grafiknya tetap terlihat panjang ke samping
        $queryTahun = Rkpd::join('tahun', 'rkpd.id_tahun', '=', 'tahun.id');
        if ($request->filled('opd')) {
            $queryTahun->whereExists(function ($q) use ($request) {
                $q->select(DB::raw(1))->from('opd')->whereColumn('opd.id', 'rkpd.id_opd')->where('nama_opd', $request->opd);
            });
        }
        $dataTahunTrend = $queryTahun->select('tahun.tahun as label_thn', DB::raw('SUM(rkpd.anggaran) as total'))
            ->groupBy('tahun.tahun')->orderBy('tahun.tahun', 'asc')->get();

        // 7. Data Chart 3: Anggaran Per OPD (Bar Horizontal)
        $dataOpd = (clone $query)->select('opd.nama_opd', DB::raw('SUM(rkpd.anggaran) as total'))
            ->groupBy('opd.nama_opd')->get();

        // 8. Rincian Data untuk Tabel
        $rincianData = $query->with(['tahun', 'opd'])->get();

        return view('user.rkpd.index', compact(
            'listOpd', 'listTahun', 'dataProgram', 
            'dataTahunTrend', 'dataOpd', 'rincianData', 
            'totalAnggaran', 'jumlahProgram', 'jumlahKegiatan'
        ));
    }
}