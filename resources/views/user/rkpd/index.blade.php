@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen w-full">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Visualisasi RKPD</h1>
            <p class="text-sm text-gray-500">Monitoring anggaran, program, dan kegiatan OPD.</p>
        </div>

        <div class="bg-white p-2 rounded-lg shadow-sm border border-gray-200">
            <form action="{{ route('user.rkpd.index') }}" method="GET" class="flex items-center gap-2">
                <select name="tahun" class="text-xs border-gray-300 rounded focus:ring-blue-500 w-32">
                    <option value="">Semua Tahun</option>
                    @foreach($listTahun as $t)
                        <option value="{{ $t->tahun }}" {{ request('tahun') == $t->tahun ? 'selected' : '' }}>{{ $t->tahun }}</option>
                    @endforeach
                </select>
                <select name="opd" class="text-xs border-gray-300 rounded focus:ring-blue-500 w-48">
                    <option value="">Semua OPD</option>
                    @foreach($listOpd as $o)
                        <option value="{{ $o->nama_opd }}" {{ request('opd') == $o->nama_opd ? 'selected' : '' }}>{{ $o->nama_opd }}</option>
                    @endforeach
                </select>
                <div class="flex gap-1">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs hover:bg-blue-700 transition font-semibold">
                        Filter
                    </button>
                    <a href="{{ route('user.rkpd.index') }}" class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded text-xs hover:bg-gray-200 border border-gray-300 flex items-center gap-1" title="Reset Data">
                        ↺ Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-blue-600">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Anggaran</p>
            <h3 class="text-xl font-black text-gray-800 mt-1">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-green-500">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Jumlah Program</p>
            <h3 class="text-xl font-black text-gray-800 mt-1">{{ $jumlahProgram }} <span class="text-sm font-normal text-gray-500">Program</span></h3>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-yellow-500">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Kegiatan</p>
            <h3 class="text-xl font-black text-gray-800 mt-1">{{ $jumlahKegiatan }} <span class="text-sm font-normal text-gray-500">Kegiatan</span></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col h-96">
            <h3 class="font-bold text-gray-700 mb-4 text-xs text-center uppercase tracking-wider">Anggaran Per Program</h3>
            <div class="relative flex-grow">
                <canvas id="chartProgram"></canvas>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col h-96">
            <h3 class="font-bold text-gray-700 mb-4 text-xs text-center uppercase tracking-wider">Tren Anggaran Tahunan</h3>
            <div class="relative flex-grow">
                <canvas id="chartTahun"></canvas>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col h-96">
            <h3 class="font-bold text-gray-700 mb-4 text-xs text-center uppercase tracking-wider">Anggaran Per OPD</h3>
            <div class="relative flex-grow">
                <canvas id="chartOpd"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800 text-sm italic">Rincian Data Perencanaan (RKPD)</h3>
            <span class="text-xs text-gray-500">Menampilkan {{ $rincianData->count() }} data rincian</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Tahun</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">OPD</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Program</th>
                        <th class="px-6 py-3 text-left font-semibold text-gray-600 uppercase tracking-wider">Kegiatan</th>
                        <th class="px-6 py-3 text-right font-semibold text-gray-600 uppercase tracking-wider">Anggaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rincianData as $item)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->tahun->tahun ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $item->opd->nama_opd ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $item->program }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $item->kegiatan }}</td>
                        <td class="px-6 py-4 text-right font-bold text-blue-700">
                            Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">Data rincian tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const globalOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        }
    };

    // 1. PIE CHART (PROGRAM)
    new Chart(document.getElementById('chartProgram'), {
        type: 'pie',
        data: {
            labels: @json($dataProgram->pluck('program')),
            datasets: [{
                data: @json($dataProgram->pluck('total')),
                backgroundColor: ['#2563eb', '#16a34a', '#d97706', '#dc2626', '#7c3aed', '#0891b2']
            }]
        },
        options: {
            ...globalOptions,
            plugins: {
                legend: { display: true, position: 'bottom', labels: { boxWidth: 10, font: { size: 10 } } }
            }
        }
    });

    // 2. LINE CHART (TAHUNAN)
    new Chart(document.getElementById('chartTahun'), {
        type: 'line',
        data: {
            labels: @json($dataTahunTrend->pluck('label_thn')),
            datasets: [{
                label: 'Total Anggaran',
                data: @json($dataTahunTrend->pluck('total')),
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#2563eb'
            }]
        },
        options: {
            ...globalOptions,
            scales: {
                y: { beginAtZero: true, ticks: { font: { size: 10 } } },
                x: { ticks: { font: { size: 10 } } }
            }
        }
    });

    // 3. BAR CHART (OPD) - Horizontal
    new Chart(document.getElementById('chartOpd'), {
        type: 'bar',
        data: {
            labels: @json($dataOpd->pluck('nama_opd')),
            datasets: [{
                label: 'Anggaran',
                data: @json($dataOpd->pluck('total')),
                backgroundColor: '#16a34a',
                borderRadius: 4
            }]
        },
        options: {
            ...globalOptions,
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true, ticks: { font: { size: 10 } } },
                y: { ticks: { font: { size: 10 } } }
            }
        }
    });
</script>
@endsection