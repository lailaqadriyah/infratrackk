<?php

namespace App\Http\Controllers;

use App\Models\Realisasi;
use App\Models\APBD;
use App\Models\Renja;
use App\Models\Rkpd;
use App\Models\Opd;
use App\Models\Tahun;
use App\Imports\RealisasiImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RealisasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {
        $tahunFilter = $request->query('tahun');
        $opdFilter = $request->query('opd');
        
        $query = Realisasi::with(['opd', 'tahun']);
        
        if ($tahunFilter) {
            $query->where('id_tahun', $tahunFilter);
        }
        
        if ($opdFilter) {
            $query->where('id_opd', $opdFilter);
        }

        $realisasis = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());
        $tahunList = Tahun::orderBy('tahun', 'desc')->get();
        $opds = Opd::orderBy('nama_opd')->get();

        return view('admin.realisasi.index', compact('realisasis', 'tahunList', 'opds', 'tahunFilter', 'opdFilter'));
    }

    public function create()
    {
        $opds = Opd::all();
        $tahuns = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.realisasi.create', compact('opds', 'tahuns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_opd' => 'required|exists:opd,id',
            'id_tahun' => 'required|exists:tahun,id',
            'program' => 'required|string',
            'kegiatan' => 'required|string',
            'sub_kegiatan' => 'required|string',
            'indikator' => 'required|string',
            'target' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('realisasi', $fileName, 'public');
            $validated['file_path'] = 'realisasi/' . $fileName;
        }

        Realisasi::create($validated);

        return redirect()->route('admin.realisasi.index')
            ->with('success', 'Data Realisasi berhasil ditambahkan');
    }

    public function edit(Realisasi $realisasi)
    {
        $opds = Opd::all();
        $tahuns = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.realisasi.edit', compact('realisasi', 'opds', 'tahuns'));
    }

    public function update(Request $request, Realisasi $realisasi)
    {
        $validated = $request->validate([
            'id_opd' => 'required|exists:opd,id',
            'id_tahun' => 'required|exists:tahun,id',
            'program' => 'required|string',
            'kegiatan' => 'required|string',
            'sub_kegiatan' => 'required|string',
            'indikator' => 'required|string',
            'target' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($realisasi->file_path && Storage::disk('public')->exists($realisasi->file_path)) {
                Storage::disk('public')->delete($realisasi->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('realisasi', $fileName, 'public');
            $validated['file_path'] = 'realisasi/' . $fileName;
        }

        $realisasi->update($validated);

        return redirect()->route('admin.realisasi.index')
            ->with('success', 'Data Realisasi berhasil diperbarui');
    }

    public function destroy(Realisasi $realisasi)
    {
        $realisasi->delete();

        return redirect()->route('admin.realisasi.index')
            ->with('success', 'Data Realisasi berhasil dihapus');
    }

    public function uploadStore(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|exists:tahun,id',
            'id_opd' => 'required|exists:opd,id',
            'file' => 'required|file|mimes:xls,xlsx|max:5120',
        ]);

        try {
            Excel::import(
                new RealisasiImport($request->id_tahun, $request->id_opd),
                $request->file('file')
            );

            return redirect()->route('admin.realisasi.index')
                ->with('success', 'Data Realisasi berhasil diimport dari file Excel.');
        } catch (\Exception $e) {
            return redirect()->route('admin.realisasi.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
