<?php

namespace App\Http\Controllers;

use App\Models\APBD;
use App\Models\Opd;
use App\Models\Tahun;
use App\Imports\APBDImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class APBDController extends Controller
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
        
        $query = APBD::with(['opd', 'tahun']);
        
        if ($tahunFilter) {
            $query->where('id_tahun', $tahunFilter);
        }
        
        if ($opdFilter) {
            $query->where('id_opd', $opdFilter);
        }

        $apbds = $query->orderBy('id', 'desc')->paginate(10)->appends($request->query());
        $tahunList = Tahun::orderBy('tahun', 'desc')->get();
        $opds = Opd::orderBy('nama_opd')->get();

        return view('admin.apbd.index', compact('apbds', 'tahunList', 'opds', 'tahunFilter', 'opdFilter'));
    }

    public function create()
    {
        $opds = Opd::all();
        $tahuns = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.apbd.create', compact('opds', 'tahuns'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_opd' => 'required|exists:opd,id',
            'id_tahun' => 'required|exists:tahun,id',
            'kegiatan' => 'required|string',
            'sub_kegiatan' => 'required|string',
            'program' => 'nullable|string',
            'indikator' => 'nullable|string',
            'target' => 'nullable|string',
            'alokasi' => 'nullable|numeric|min:0',
        ]);

        APBD::create($validated);

        return redirect()->route('admin.apbd.index')
            ->with('success', 'Data APBD berhasil ditambahkan');
    }

    public function edit(APBD $apbd)
    {
        $opds = Opd::all();
        $tahuns = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.apbd.edit', compact('apbd', 'opds', 'tahuns'));
    }

    public function update(Request $request, APBD $apbd)
    {
        $validated = $request->validate([
            'id_opd' => 'required|exists:opd,id',
            'id_tahun' => 'required|exists:tahun,id',
            'kegiatan' => 'required|string',
            'sub_kegiatan' => 'required|string',
            'program' => 'nullable|string',
            'alokasi' => 'nullable|numeric|min:0',
            'nama_daerah' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file')) {
            if ($apbd->file_path && Storage::disk('public')->exists($apbd->file_path)) {
                Storage::disk('public')->delete($apbd->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('realisasi', $fileName, 'public');
            $validated['file_path'] = 'realisasi/' . $fileName;
        }

        $apbd->update($validated);

        return redirect()->route('admin.apbd.index')
            ->with('success', 'Data APBD berhasil diperbarui');
    }

    public function destroy(APBD $apbd)
    {
        $apbd->delete();

        return redirect()->route('admin.apbd.index')
            ->with('success', 'Data APBD berhasil dihapus');
    }

    public function import(Request $request)
    {
        $request->validate([
            'id_tahun' => 'required|exists:tahun,id',
            'id_opd' => 'required|exists:opd,id',
            'file' => 'required|file|mimes:xls,xlsx|max:5120',
        ]);

        try {
            Excel::import(
                new APBDImport($request->id_tahun, $request->id_opd),
                $request->file('file')
            );

            return redirect()->route('admin.apbd.index')
                ->with('success', 'Data APBD berhasil diimport dari file Excel.');
        } catch (\Exception $e) {
            return redirect()->route('admin.apbd.index')
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
