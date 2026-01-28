<?php

namespace App\Http\Controllers;

use App\Models\Renja;
use App\Models\Rkpd;
use App\Models\Opd;
use App\Models\Tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RenjaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('is_admin');
    }

    public function index(Request $request)
    {
        $tahun = $request->query('tahun');
        
        $query = Renja::with(['opd', 'tahun']);
        
        if ($tahun) {
            $query->whereHas('tahun', function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
            });
        }

        $renjas = $query->paginate(10);
        $tahunList = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.renja.index', compact('renjas', 'tahunList', 'tahun'));
    }

    public function create()
    {
        $opds = Opd::all();
        $tahuns = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.renja.create', compact('opds', 'tahuns'));
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
            $file->storeAs('renja', $fileName, 'public');
            $validated['file_path'] = 'renja/' . $fileName;
        }

        Renja::create($validated);

        return redirect()->route('admin.renja.index')
            ->with('success', 'Data RENJA berhasil ditambahkan');
    }

    public function edit(Renja $renja)
    {
        $opds = Opd::all();
        $tahuns = Tahun::orderBy('tahun', 'desc')->get();

        return view('admin.renja.edit', compact('renja', 'opds', 'tahuns'));
    }

    public function update(Request $request, Renja $renja)
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
            if ($renja->file_path && Storage::disk('public')->exists($renja->file_path)) {
                Storage::disk('public')->delete($renja->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('renja', $fileName, 'public');
            $validated['file_path'] = 'renja/' . $fileName;
        }

        $renja->update($validated);

        return redirect()->route('admin.renja.index')
            ->with('success', 'Data RENJA berhasil diperbarui');
    }

    public function destroy(Renja $renja)
    {
        $renja->delete();

        return redirect()->route('admin.renja.index')
            ->with('success', 'Data RENJA berhasil dihapus');
    }
}
