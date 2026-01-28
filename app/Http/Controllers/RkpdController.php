<?php

namespace App\Http\Controllers;

use App\Models\Rkpd;
use App\Models\Opd;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RkpdController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {
        $tahun = $request->query('tahun');
        
        $query = Rkpd::with(['opd', 'tahun']);
        
        if ($tahun) {
            $query->whereHas('tahun', function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
            });
        }

        $rkpds = $query->paginate(10);
        $tahunList = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.rkpd.index', compact('rkpds', 'tahunList', 'tahun'));
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
}
