<?php

namespace App\Http\Controllers;

use App\Models\Rkpd;
use App\Models\Opd;
use App\Models\Tahun;
use App\Imports\RkpdImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class RkpdController extends Controller
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
        
        $query = Rkpd::with(['opd', 'tahun']);
        
        if ($tahunFilter) {
            $query->where('id_tahun', $tahunFilter);
        }
        
        if ($opdFilter) {
            $query->where('id_opd', $opdFilter);
        }

        $rkpds = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());
        $tahunList = Tahun::orderBy('tahun', 'desc')->get();
        $opds = Opd::orderBy('nama_opd')->get();

        return view('admin.rkpd.index', compact('rkpds', 'tahunList', 'opds', 'tahunFilter', 'opdFilter'));
    }

    public function create()
    {
        $opds = Opd::all();
        $tahuns = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.rkpd.create', compact('opds', 'tahuns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_opd' => 'required|exists:opd,id',
            'id_tahun' => 'required|exists:tahun,id',
            'program' => 'required|string',
            'kegiatan' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('rkpd', $fileName, 'public');
            $validated['file_path'] = 'rkpd/' . $fileName;
        }

        Rkpd::create($validated);

        return redirect()->route('admin.rkpd.index')
            ->with('success', 'Data RKPD berhasil ditambahkan');
    }

    public function edit(Rkpd $rkpd)
    {
        $opds = Opd::all();
        $tahuns = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.rkpd.edit', compact('rkpd', 'opds', 'tahuns'));
    }

    public function update(Request $request, Rkpd $rkpd)
    {
        $validated = $request->validate([
            'id_opd' => 'required|exists:opd,id',
            'id_tahun' => 'required|exists:tahun,id',
            'program' => 'required|string',
            'kegiatan' => 'required|string',
            'anggaran' => 'required|numeric|min:0',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($rkpd->file_path && Storage::disk('public')->exists($rkpd->file_path)) {
                Storage::disk('public')->delete($rkpd->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('rkpd', $fileName, 'public');
            $validated['file_path'] = 'rkpd/' . $fileName;
        }

        $rkpd->update($validated);

        return redirect()->route('admin.rkpd.index')
            ->with('success', 'Data RKPD berhasil diperbarui');
    }

    public function destroy(Rkpd $rkpd)
    {
        $rkpd->delete();

        return redirect()->route('admin.rkpd.index')
            ->with('success', 'Data RKPD berhasil dihapus');
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
                new RkpdImport($request->id_tahun, $request->id_opd),
                $request->file('file')
            );

            return redirect()->route('admin.rkpd.index')
                ->with('success', 'Data RKPD berhasil diimport dari file Excel.');
        } catch (\Exception $e) {
            return redirect()->route('admin.rkpd.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
