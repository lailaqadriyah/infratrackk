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

        // 2. Base Query dengan Join
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

        // 4. Statistik Atas (menggunakan kolom `pagu` dari tabel apbd)
        $totalAnggaran = (clone $query)->sum('apbd.pagu');
        // Tabel apbd tidak memiliki kolom `program` secara eksplisit; gunakan distinct pada `kegiatan` sebagai representasi program jika diperlukan
        $jumlahProgram = (clone $query)->distinct('apbd.kegiatan')->count('apbd.kegiatan');
        $jumlahKegiatan = (clone $query)->distinct('apbd.sub_kegiatan')->count('apbd.sub_kegiatan');

        // 5. Data Visualisasi (mengelompokkan berdasarkan 'kegiatan' untuk melihat porsi)
        $dataProgram = (clone $query)->select('apbd.kegiatan as program', DB::raw('SUM(apbd.pagu) as total'))
            ->groupBy('apbd.kegiatan')->get();

        $dataTahunTrend = APBD::join('tahun', 'apbd.id_tahun', '=', 'tahun.id')
            ->select('tahun.tahun as label_thn', DB::raw('SUM(apbd.pagu) as total'))
            ->when($request->opd, function($q) use ($request) {
                return $q->whereExists(function($sub) use ($request) {
                    $sub->select(DB::raw(1))->from('opd')->whereColumn('opd.id', 'apbd.id_opd')->where('nama_opd', $request->opd);
                });
            })
            ->groupBy('tahun.tahun')->orderBy('tahun.tahun', 'asc')->get();

        $dataOpd = (clone $query)->select('opd.nama_opd', DB::raw('SUM(apbd.pagu) as total'))
            ->groupBy('opd.nama_opd')->get();

        // 5b. Data Realisasi Per OPD
        $dataRealisasiOpd = Realisasi::join('opd', 'realisasi.id_opd', '=', 'opd.id')
            ->join('tahun', 'realisasi.id_tahun', '=', 'tahun.id')
            ->when($request->filled('tahun'), function($q) use ($request) {
                return $q->where('tahun.tahun', $request->tahun);
            })
            ->when($request->filled('opd'), function($q) use ($request) {
                return $q->where('opd.nama_opd', $request->opd);
            })
            ->select('opd.nama_opd', DB::raw('SUM(realisasi.alokasi) as total'))
            ->groupBy('opd.nama_opd')->get();

        // 6. Rincian Data - aggregate per Tahun, OPD, Program
        $rincianData = (clone $query)
            ->select('tahun.tahun as label_tahun', 'opd.nama_opd', 'apbd.program', DB::raw('SUM(COALESCE(apbd.alokasi, apbd.pagu, 0)) as total_alokasi'))
            ->groupBy('tahun.tahun', 'opd.nama_opd', 'apbd.program')
            ->orderBy('tahun.tahun', 'desc')
            ->get();

        return view('user.apbd.index', compact(
            'listOpd', 'listTahun', 'dataProgram', 
            'dataTahunTrend', 'dataOpd', 'dataRealisasiOpd', 'rincianData', 
            'totalAnggaran', 'jumlahProgram', 'jumlahKegiatan'
        ));
    }

    public function program(Request $request, $program)
    {
        $program = urldecode($program);
        $listOpd = Opd::orderBy('nama_opd', 'asc')->get();
        $listTahun = Tahun::orderBy('tahun', 'desc')->get();

        $query = APBD::query()
            ->join('tahun', 'apbd.id_tahun', '=', 'tahun.id')
            ->join('opd', 'apbd.id_opd', '=', 'opd.id')
            ->where('apbd.program', $program);

        if ($request->filled('tahun')) {
            $query->where('tahun.tahun', $request->tahun);
        }
        if ($request->filled('opd')) {
            $query->where('opd.nama_opd', $request->opd);
        }

        $kegiatans = $query->select('apbd.kegiatan', DB::raw('SUM(COALESCE(apbd.alokasi, apbd.pagu,0)) as total'))
            ->groupBy('apbd.kegiatan')
            ->get();

        return view('user.apbd.program', compact('listOpd', 'listTahun', 'program', 'kegiatans'));
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

        if ($request->filled('tahun')) {
            $query->where('tahun.tahun', $request->tahun);
        }
        if ($request->filled('opd')) {
            $query->where('opd.nama_opd', $request->opd);
        }

        $details = $query->select(
            'tahun.tahun as label_tahun',
            'opd.nama_opd',
            'apbd.sub_kegiatan',
            'apbd.nama_sumber_dana',
            'apbd.nama_rekening',
            'apbd.nama_daerah',
            DB::raw('SUM(COALESCE(apbd.alokasi, apbd.pagu,0)) as total_alokasi')
        )->groupBy('tahun.tahun','opd.nama_opd','apbd.sub_kegiatan','apbd.nama_sumber_dana','apbd.nama_rekening','apbd.nama_daerah')
        ->get();

        return view('user.apbd.kegiatan', compact('program','kegiatan','details'));
    }
}