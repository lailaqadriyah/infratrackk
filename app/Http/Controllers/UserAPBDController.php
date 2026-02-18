<?php

namespace App\Http\Controllers;

use App\Models\APBD;
use App\Models\Opd;
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

        // 2. Base Query dengan Join (menggunakan APBD)
        $query = APBD::query()
            ->join('tahun', 'apbd.id_tahun', '=', 'tahun.id')
            ->join('opd', 'apbd.id_opd', '=', 'opd.id')
            ->select('apbd.*', 'tahun.tahun as label_tahun', 'opd.nama_opd');

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
                $w->where('apbd.program', 'like', "%{$q}%")
                  ->orWhere('apbd.kegiatan', 'like', "%{$q}%")
                  ->orWhere('apbd.sub_kegiatan', 'like', "%{$q}%")
                  ->orWhere('apbd.nama_daerah', 'like', "%{$q}%");
            });
        }

        // 4. Statistik Atas (menggunakan kolom alokasi dari APBD)
        $totalAnggaran = (clone $query)->sum('apbd.alokasi');
        $jumlahProgram = (clone $query)->distinct('apbd.program')->count('apbd.program');
        $jumlahKegiatan = (clone $query)->distinct('apbd.kegiatan')->count('apbd.kegiatan');

        // 5. Data Visualisasi (mengelompokkan berdasarkan program)
        $dataProgram = (clone $query)->select('apbd.program', DB::raw('SUM(apbd.alokasi) as total'))
            ->groupBy('apbd.program')->get();

        $dataTahunTrend = APBD::join('tahun', 'apbd.id_tahun', '=', 'tahun.id')
            ->select('tahun.tahun as label_thn', DB::raw('SUM(apbd.alokasi) as total'))
            ->when($request->filled('tahun'), function($q) use ($request) {
                return $q->where('tahun.tahun', $request->tahun);
            })
            ->when($request->filled('opd'), function($q) use ($request) {
                return $q->whereExists(function($sub) use ($request) {
                    $sub->select(DB::raw(1))->from('opd')->whereColumn('opd.id', 'apbd.id_opd')->where('nama_opd', $request->opd);
                });
            })
            ->groupBy('tahun.tahun')->orderBy('tahun.tahun', 'asc')->get();

        $dataOpd = (clone $query)->select('opd.nama_opd', DB::raw('SUM(apbd.alokasi) as total'))
            ->groupBy('opd.nama_opd')->get();

        // 6. Rincian Data - aggregate per Tahun, OPD, Program (dari APBD)
        $rincianData = (clone $query)
            ->select('tahun.tahun as label_tahun', 'opd.nama_opd', 'apbd.program', DB::raw('SUM(apbd.alokasi) as total_alokasi'))
            ->groupBy('tahun.tahun', 'opd.nama_opd', 'apbd.program')
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

        $query = APBD::query()
            ->join('tahun', 'apbd.id_tahun', '=', 'tahun.id')
            ->join('opd', 'apbd.id_opd', '=', 'opd.id')
            ->where('apbd.program', $program);

        // search within kegiatan names
        if ($request->filled('q')) {
            $qq = $request->q;
            $query->where('apbd.kegiatan', 'like', "%{$qq}%");
        }

        $kegiatans = $query->select('apbd.kegiatan', DB::raw('SUM(apbd.alokasi) as total'))
            ->groupBy('apbd.kegiatan')
            ->get();

        return view('user.apbd.program', compact('program', 'kegiatans'));
    }

    public function kegiatan(Request $request, $program, $kegiatan)
    {
        $program = urldecode($program);
        $kegiatan = urldecode($kegiatan);

        $query = APBD::query()
            ->join('tahun', 'apbd.id_tahun', '=', 'tahun.id')
            ->join('opd', 'apbd.id_opd', '=', 'opd.id')
            ->where('apbd.program', $program)
            ->where('apbd.kegiatan', $kegiatan);

        // search within details
        if ($request->filled('q')) {
            $qq = $request->q;
            $query->where(function($w) use ($qq) {
                $w->where('apbd.sub_kegiatan', 'like', "%{$qq}%")
                  ->orWhere('apbd.nama_daerah', 'like', "%{$qq}%");
            });
        }

        $details = $query->select(
            'tahun.tahun as label_tahun',
            'opd.nama_opd',
            'apbd.sub_kegiatan',
            'apbd.nama_daerah',
            DB::raw('SUM(apbd.alokasi) as total_alokasi')
        )->groupBy('tahun.tahun','opd.nama_opd','apbd.sub_kegiatan','apbd.nama_daerah')
        ->get();

        return view('user.apbd.kegiatan', compact('program','kegiatan','details'));
    }
}