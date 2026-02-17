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

        // 4. Statistik Atas (Total Alokasi, Jumlah Sub Kegiatan, Jumlah Daerah)
        $totalAlokasi = (clone $query)->sum('realisasi.alokasi');
        $jumlahSubKegiatan = (clone $query)->distinct('realisasi.sub_kegiatan')->count('realisasi.sub_kegiatan');
        $jumlahDaerah = (clone $query)->distinct('realisasi.nama_daerah')->count('realisasi.nama_daerah');

        // 5. Data Visualisasi (Sub Kegiatan, Trend Tahun, Daerah)
        $dataSubKegiatan = (clone $query)->select('realisasi.sub_kegiatan', DB::raw('SUM(realisasi.alokasi) as total'))
            ->groupBy('realisasi.sub_kegiatan')->get();

        $dataTahunTrend = Realisasi::join('tahun', 'realisasi.id_tahun', '=', 'tahun.id')
            ->select('tahun.tahun as label_thn', DB::raw('SUM(realisasi.alokasi) as total'))
            ->when($request->opd, function($q) use ($request) {
                return $q->whereExists(function($sub) use ($request) {
                    $sub->select(DB::raw(1))->from('opd')->whereColumn('opd.id', 'realisasi.id_opd')->where('nama_opd', $request->opd);
                });
            })
            ->groupBy('tahun.tahun')->orderBy('tahun.tahun', 'asc')->get();

        $dataDaerah = (clone $query)->select('realisasi.nama_daerah', DB::raw('SUM(realisasi.alokasi) as total'))
            ->groupBy('realisasi.nama_daerah')->get();

        // 6. Rincian Data - Get the filtered IDs, then fetch with all attributes
        $filteredIds = (clone $query)->select('realisasi.id')->pluck('realisasi.id');
        $rincianData = Realisasi::whereIn('id', $filteredIds)
            ->join('tahun', 'realisasi.id_tahun', '=', 'tahun.id')
            ->select('realisasi.*', 'tahun.tahun as label_tahun')
            ->get();

        return view('user.realisasi.index', compact(
            'listOpd', 'listTahun', 'dataSubKegiatan', 
            'dataTahunTrend', 'dataDaerah', 'rincianData', 
            'totalAlokasi', 'jumlahSubKegiatan', 'jumlahDaerah'
        ));
    }

    public function edit(Realisasi $realisasi)
    {
        $opds = Opd::all();
        $tahuns = Tahun::orderBy('tahun', 'desc')->get();

        return view('user.realisasi.edit', compact('realisasi', 'opds', 'tahuns'));
    }

    public function update(Request $request, Realisasi $realisasi)
    {
        $validated = $request->validate([
            'id_opd' => 'required|exists:opd,id',
            'id_tahun' => 'required|exists:tahun,id',
            'alokasi' => 'required|numeric|min:0',
            'kegiatan' => 'nullable|string',
            'sub_kegiatan' => 'required|string',
            'nama_daerah' => 'required|string',
        ]);

        $realisasi->update($validated);

        return redirect()->route('user.realisasi.index')
            ->with('success', 'Data Realisasi berhasil diperbarui');
    }
}