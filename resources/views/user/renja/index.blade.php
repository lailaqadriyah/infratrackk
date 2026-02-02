@extends('layouts.app')

@section('page-title', 'Dashboard RENJA User')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen w-full">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Visualisasi RENJA</h1>
        <p class="text-gray-600">Analisis anggaran dan rincian data perencanaan tahun 2026.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-blue-600 transition-transform hover:scale-[1.02]">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Anggaran</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-green-600 transition-transform hover:scale-[1.02]">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Jumlah Program</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $jumlahProgram }} Program</h3>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-l-4 border-yellow-500 transition-transform hover:scale-[1.02]">
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Kegiatan</p>
            <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $jumlahKegiatan }} Kegiatan</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-6 text-center">Proporsi Anggaran Per Program</h3>
            <div class="h-64">
                <canvas id="pieChart" 
                    data-labels='@json($chartData->pluck("program"))' 
                    data-values='@json($chartData->pluck("total"))'>
                </canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-6 text-center">Top 5 Anggaran Sub-Kegiatan</h3>
            <div class="h-64">
                <canvas id="barChart" 
                    data-labels='@json($barData->pluck("sub_kegiatan")->map(fn($item) => \Illuminate\Support\Str::limit($item, 15)))' 
                    data-values='@json($barData->pluck("anggaran"))'>
                </canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-6 text-center">Sebaran Jenis Satuan Target</h3>
            <div class="h-64">
                <canvas id="targetChart" 
                    data-labels='@json($targetUnitLabels)' 
                    data-values='@json($targetUnitValues)'>
                </canvas>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-white">
            <h3 class="font-bold text-gray-800 uppercase tracking-wide text-sm">Rincian Data Perencanaan (RENJA)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border-collapse">
                <thead>
                    <tr class="bg-gray-50 text-gray-700 uppercase text-xs font-bold">
                        <th class="px-6 py-4 border-b">Program</th>
                        <th class="px-6 py-4 border-b">Kegiatan</th>
                        <th class="px-6 py-4 border-b">Sub-Kegiatan</th>
                        <th class="px-6 py-4 border-b">Indikator</th>
                        <th class="px-6 py-4 border-b">Target</th>
                        <th class="px-6 py-4 border-b text-right">Anggaran</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-600">
                    @forelse($allRenja as $item)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $item->program }}</td>
                        <td class="px-6 py-4">{{ $item->kegiatan }}</td>
                        <td class="px-6 py-4">{{ $item->sub_kegiatan }}</td>
                        <td class="px-6 py-4">{{ $item->indikator }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $item->target }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-blue-700 whitespace-nowrap">
                            Rp {{ number_format($item->anggaran, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">
                            Belum ada data perencanaan yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi pembantu untuk Parse Data JSON tanpa error editor
        const parseChartData = (id) => {
            const el = document.getElementById(id);
            if (!el) return { labels: [], values: [] };
            return {
                labels: JSON.parse(el.getAttribute('data-labels') || '[]'),
                values: JSON.parse(el.getAttribute('data-values') || '[]')
            };
        };

        // 1. Doughnut Chart (Proporsi Program)
        const pieData = parseChartData('pieChart');
        new Chart(document.getElementById('pieChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: pieData.labels,
                datasets: [{
                    data: pieData.values,
                    backgroundColor: ['#2563eb', '#16a34a', '#d97706', '#dc2626', '#7c3aed', '#0ea5e9'],
                    borderWidth: 2
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
        });

        // 2. Bar Chart (Top 5 Anggaran)
        const barData = parseChartData('barChart');
        new Chart(document.getElementById('barChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: barData.labels,
                datasets: [{
                    label: 'Pagu Anggaran',
                    data: barData.values,
                    backgroundColor: '#3b82f6',
                    borderRadius: 6
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // 3. Target Chart (Horizontal Bar)
        const targetData = parseChartData('targetChart');
        new Chart(document.getElementById('targetChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: targetData.labels,
                datasets: [{
                    label: 'Jumlah Kegiatan',
                    data: targetData.values,
                    backgroundColor: '#8b5cf6',
                    borderRadius: 5
                }]
            },
            options: { 
                indexAxis: 'y',
                responsive: true, 
                maintainAspectRatio: false, 
                plugins: { legend: { display: false } }
            }
        });
    });
</script>
@endsection