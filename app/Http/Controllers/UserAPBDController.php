<?php

namespace App\Http\Controllers;

use App\Models\APBD;
use App\Models\Opd;
use App\Models\Realisasi;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAPBDController extends Controller
{
    public function index(Request $request)
    {
        // 1. Data untuk Dropdown Filter
        $listOpd = Opd::orderBy('nama_opd', 'asc')->get();
        $listTahun = Tahun::orderBy('tahun', 'desc')->get();

        // 2. Base Query dengan Join (menggunakan Realisasi dari admin DPA OPD)
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
        // 3b. Search query
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($w) use ($q) {
                $w->where('realisasi.program', 'like', "%{$q}%")
                  ->orWhere('realisasi.kegiatan', 'like', "%{$q}%")
                  ->orWhere('realisasi.sub_kegiatan', 'like', "%{$q}%")
                  ->orWhere('realisasi.nama_daerah', 'like', "%{$q}%");
            });
        }

        // 4. Statistik Atas (menggunakan kolom alokasi dari Realisasi)
        $totalAnggaran = (clone $query)->sum('realisasi.alokasi');
        $jumlahProgram = (clone $query)->distinct('realisasi.program')->count('realisasi.program');
        $jumlahKegiatan = (clone $query)->distinct('realisasi.kegiatan')->count('realisasi.kegiatan');

        // 5. Data Visualisasi (mengelompokkan berdasarkan program)
        $dataProgram = (clone $query)->select('realisasi.program', DB::raw('SUM(realisasi.alokasi) as total'))
            ->groupBy('realisasi.program')->get();

        $dataTahunTrend = Realisasi::join('tahun', 'realisasi.id_tahun', '=', 'tahun.id')
            ->select('tahun.tahun as label_thn', DB::raw('SUM(realisasi.alokasi) as total'))
            ->when($request->filled('tahun'), function($q) use ($request) {
                return $q->where('tahun.tahun', $request->tahun);
            })
            ->when($request->filled('opd'), function($q) use ($request) {
                return $q->whereExists(function($sub) use ($request) {
                    $sub->select(DB::raw(1))->from('opd')->whereColumn('opd.id', 'realisasi.id_opd')->where('nama_opd', $request->opd);
                });
            })
            ->groupBy('tahun.tahun')->orderBy('tahun.tahun', 'asc')->get();

        $dataOpd = (clone $query)->select('opd.nama_opd', DB::raw('SUM(realisasi.alokasi) as total'))
            ->groupBy('opd.nama_opd')->get();

        // 6. Rincian Data - aggregate per Tahun, OPD, Program (dari Realisasi)
        $rincianData = (clone $query)
            ->select('tahun.tahun as label_tahun', 'opd.nama_opd', 'realisasi.program', DB::raw('SUM(realisasi.alokasi) as total_alokasi'))
            ->groupBy('tahun.tahun', 'opd.nama_opd', 'realisasi.program')
            ->orderBy('tahun.tahun', 'desc')
            ->get();

        return view('user.apbd.index', compact(
            'listOpd', 'listTahun', 'dataProgram', 
            'dataTahunTrend', 'dataOpd', 'rincianData', 
            'totalAnggaran', 'jumlahProgram', 'jumlahKegiatan'
        ));
    }

    public function program(Request $request, $program)
    {
        $program = urldecode($program);

        $query = Realisasi::query()
            ->join('tahun', 'realisasi.id_tahun', '=', 'tahun.id')
            ->join('opd', 'realisasi.id_opd', '=', 'opd.id')
            ->where('realisasi.program', $program);

        // search within kegiatan names
        if ($request->filled('q')) {
            $qq = $request->q;
            $query->where('realisasi.kegiatan', 'like', "%{$qq}%");
        }

        $kegiatans = $query->select('realisasi.kegiatan', DB::raw('SUM(realisasi.alokasi) as total'))
            ->groupBy('realisasi.kegiatan')
            ->get();

        return view('user.apbd.program', compact('program', 'kegiatans'));
    }

    public function kegiatan(Request $request, $program, $kegiatan)
    {
        $program = urldecode($program);
        $kegiatan = urldecode($kegiatan);

        $query = Realisasi::query()
            ->join('tahun', 'realisasi.id_tahun', '=', 'tahun.id')
            ->join('opd', 'realisasi.id_opd', '=', 'opd.id')
            ->where('realisasi.program', $program)
            ->where('realisasi.kegiatan', $kegiatan);

        // search within details
        if ($request->filled('q')) {
            $qq = $request->q;
            $query->where(function($w) use ($qq) {
                $w->where('realisasi.sub_kegiatan', 'like', "%{$qq}%")
                  ->orWhere('realisasi.nama_daerah', 'like', "%{$qq}%");
            });
        }

        $details = $query->select(
            'tahun.tahun as label_tahun',
            'opd.nama_opd',
            'realisasi.sub_kegiatan',
            'realisasi.nama_daerah',
            DB::raw('SUM(realisasi.alokasi) as total_alokasi')
        )->groupBy('tahun.tahun','opd.nama_opd','realisasi.sub_kegiatan','realisasi.nama_daerah')
        ->get();

        return view('user.apbd.kegiatan', compact('program','kegiatan','details'));
    }
}