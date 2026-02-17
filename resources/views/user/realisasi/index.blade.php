@extends('layouts.app')
@section('header', 'Dashboard Realisasi')
@section('header_description', 'Analisis dan pemantauan data Realisasi tahun berjalan.')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen w-full">
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-end gap-4">
    <div class="bg-white p-2 rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('user.realisasi.index') }}" method="GET" class="flex items-center gap-2">
            <select name="tahun" class="text-xs border-gray-300 rounded focus:ring-blue-500 w-40">
                <option value="">Semua Tahun</option>
                @foreach($listTahun as $t)
                    <option value="{{ $t->tahun }}" {{ request('tahun') == $t->tahun ? 'selected' : '' }}>{{ $t->tahun }}</option>
                @endforeach
            </select>
            <select name="opd" class="text-xs border-gray-300 rounded focus:ring-blue-500 w-40">
                <option value="">Semua OPD</option>
                @foreach($listOpd as $o)
                    <option value="{{ $o->nama_opd }}" {{ request('opd') == $o->nama_opd ? 'selected' : '' }}>{{ $o->nama_opd }}</option>
                @endforeach
            </select>
            <div class="flex gap-1">
                <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 rounded text-xs hover:bg-blue-700 transition font-semibold">
                    Filter
                </button>
                <a href="{{ route('user.realisasi.index') }}" class="bg-gray-100 text-gray-600 px-3 py-1.5 rounded text-xs hover:bg-gray-200 border border-gray-300 flex items-center gap-1">
                    ↺ Reset
                </a>
            </div>
        </form>
    </div>
</div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-blue-600">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Total Alokasi</p>
            <h3 class="text-xl font-black text-gray-800 mt-1">Rp {{ number_format($totalAlokasi, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-green-500">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Jumlah Sub Kegiatan</p>
            <h3 class="text-xl font-black text-gray-800 mt-1">{{ $jumlahSubKegiatan }} <span class="text-sm font-normal text-gray-500">Sub Kegiatan</span></h3>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border-l-4 border-yellow-500">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Jumlah Daerah</p>
            <h3 class="text-xl font-black text-gray-800 mt-1">{{ $jumlahDaerah }} <span class="text-sm font-normal text-gray-500">Daerah</span></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col h-96">
            <h3 class="font-bold text-gray-700 mb-4 text-xs text-center uppercase tracking-wider">Porsi Alokasi Sub Kegiatan</h3>
            <div class="relative flex-grow">
                <canvas id="realisasiPie"></canvas>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col h-96">
            <h3 class="font-bold text-gray-700 mb-4 text-xs text-center uppercase tracking-wider">Trend Alokasi Realisasi</h3>
            <div class="relative flex-grow">
                <canvas id="realisasiLine"></canvas>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col h-96">
            <h3 class="font-bold text-gray-700 mb-4 text-xs text-center uppercase tracking-wider">Alokasi Per Daerah</h3>
            <div class="relative flex-grow">
                <canvas id="realisasiBar"></canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b bg-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800 text-sm italic">Rincian Data Anggaran (Realisasi)</h3>
            <span class="text-xs text-gray-500">Menampilkan {{ $rincianData->count() }} data rincian</span>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-blue-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Tahun</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Kegiatan</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Alokasi</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Sub Kegiatan</th>
                        <th class="px-4 py-3 border-x text-center font-semibold text-black-600 uppercase tracking-wider">Nama Daerah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($rincianData as $item)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-4 py-4 border-x border-gray-200 text-black-700">{{ $item->label_tahun ?? '-' }}</td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600">{{ $item->kegiatan ?? '-' }}</td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600 whitespace-nowrap">
                            Rp {{ number_format($item->alokasi ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600">{{ $item->sub_kegiatan ?? '-' }}</td>
                        <td class="px-4 py-4 border-x border-gray-200 text-black-600">{{ $item->nama_daerah ?? '-' }}</td>
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
    // Konfigurasi Dasar untuk Semua Chart agar Rapi
    const globalOptions = {
        responsive: true,
        maintainAspectRatio: false,
        layout: {
            padding: { top: 10, bottom: 10, left: 10, right: 10 }
        },
        plugins: {
            legend: { display: false }
        }
    };

    // 1. Doughnut Chart (Sub Kegiatan)
    new Chart(document.getElementById('realisasiPie'), {
        type: 'doughnut',
        data: {
            labels: @json($dataSubKegiatan->pluck('sub_kegiatan')),
            datasets: [{
                data: @json($dataSubKegiatan->pluck('total')),
                backgroundColor: ['#6366f1', '#8b5cf6', '#ec4899', '#f43f5e', '#f59e0b', '#0891b2'],
                borderWidth: 2,
                hoverOffset: 15
            }]
        },
        options: {
            ...globalOptions,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        font: { size: 10, weight: '500' },
                        // Memotong label yang terlalu panjang agar rapi
                        generateLabels: (chart) => {
                            const data = chart.data;
                            return data.labels.map((label, i) => ({
                                text: label.length > 20 ? label.substring(0, 20) + '...' : label,
                                fillStyle: data.datasets[0].backgroundColor[i],
                                index: i
                            }));
                        }
                    }
                }
            }
        }
    });

    // 2. Line Chart (Tren Alokasi)
    new Chart(document.getElementById('realisasiLine'), {
        type: 'line',
        data: {
            labels: @json($dataTahunTrend->pluck('label_thn')),
            datasets: [{
                label: 'Total Alokasi',
                data: @json($dataTahunTrend->pluck('total')),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: '#10b981',
                pointHoverRadius: 7
            }]
        },
        options: {
            ...globalOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        font: { size: 10 },
                        // Format angka ke jutaan/miliar agar tidak kepanjangan
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                },
                x: { ticks: { font: { size: 10 } } }
            }
        }
    });

    // 3. Bar Chart Horizontal (Daerah)
    new Chart(document.getElementById('realisasiBar'), {
        type: 'bar',
        data: {
            labels: @json($dataDaerah->pluck('nama_daerah')),
            datasets: [{
                label: 'Alokasi',
                data: @json($dataDaerah->pluck('total')),
                backgroundColor: '#f59e0b',
                borderRadius: 5,
                barThickness: 20 // Membuat batang tidak terlalu lebar
            }]
        },
        options: {
            ...globalOptions,
            indexAxis: 'y',
            scales: {
                x: { 
                    beginAtZero: true, 
                    ticks: { font: { size: 10 } } 
                },
                y: { 
                    ticks: { 
                        font: { size: 10 },
                        // Memotong nama Daerah yang terlalu panjang
                        callback: function(value) {
                            const label = this.getLabelForValue(value);
                            return label.length > 15 ? label.substring(0, 15) + '...' : label;
                        }
                    } 
                }
            }
        }
    });
</script>
@endsection