<?php

namespace App\Http\Controllers;

use App\Models\Renja;
use App\Models\Opd;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRenjaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data untuk Dropdown Filter
        $listOpd = Opd::orderBy('nama_opd', 'asc')->get();
        $listTahun = Tahun::orderBy('tahun', 'desc')->get();

        // 2. Base Query dengan Join
        $query = Renja::query()
            ->join('tahun', 'renja.id_tahun', '=', 'tahun.id')
            ->join('opd', 'renja.id_opd', '=', 'opd.id')
            ->select('renja.*', 'tahun.tahun as label_tahun', 'opd.nama_opd');

        // 3. Logika Filter
        if ($request->filled('tahun')) {
            $query->where('tahun.tahun', $request->tahun);
        }
        if ($request->filled('opd')) {
            $query->where('opd.nama_opd', $request->opd);
        }

        // 4. Statistik Atas (Samakan dengan RKPD)
        $totalAnggaran = (clone $query)->sum('renja.anggaran');
        $jumlahProgram = (clone $query)->distinct('renja.program')->count('renja.program');
        $jumlahKegiatan = (clone $query)->distinct('renja.kegiatan')->count('renja.kegiatan');

        // 5. Data Visualisasi (Ukuran disamakan dengan RKPD)
        $dataProgram = (clone $query)->select('renja.program', DB::raw('SUM(renja.anggaran) as total'))
            ->groupBy('renja.program')->get();

        $dataTahunTrend = Renja::join('tahun', 'renja.id_tahun', '=', 'tahun.id')
            ->select('tahun.tahun as label_thn', DB::raw('SUM(renja.anggaran) as total'))
            ->when($request->opd, function($q) use ($request) {
                return $q->whereExists(function($sub) use ($request) {
                    $sub->select(DB::raw(1))->from('opd')->whereColumn('opd.id', 'renja.id_opd')->where('nama_opd', $request->opd);
                });
            })
            ->groupBy('tahun.tahun')->orderBy('tahun.tahun', 'asc')->get();

        $dataOpd = (clone $query)->select('opd.nama_opd', DB::raw('SUM(renja.anggaran) as total'))
            ->groupBy('opd.nama_opd')->get();

        // 6. Rincian Data
        $rincianData = $query->with(['tahun', 'opd'])->get();

        return view('user.renja.index', compact(
            'listOpd', 'listTahun', 'dataProgram', 
            'dataTahunTrend', 'dataOpd', 'rincianData', 
            'totalAnggaran', 'jumlahProgram', 'jumlahKegiatan'
        ));
    }
}