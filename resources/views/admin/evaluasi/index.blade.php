@extends('layouts.admin_layout')

@section('title', 'Modul Evaluasi')

@section('content')
<div class="min-h-screen bg-gray-50 -mx-6 -mt-6">

    {{-- HEADER --}}
    <header class="bg-white border-b border-gray-200 px-6 py-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="p-2 bg-gradient-to-br from-blue-600 to-green-600 rounded-lg">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          d="M3 3v18h18M7 16V9m4 7V5m4 11v-6" />
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-semibold text-gray-900">Modul Evaluasi</h1>
                <p class="text-sm text-gray-600">Analisis feedback masyarakat</p>
            </div>
        </div>
    </header>

    <div class="px-6 pb-10">

        {{-- STAT CARDS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <p class="text-sm text-gray-600 mb-1">Total Feedback</p>
                <p class="text-3xl font-semibold text-gray-900">{{ $totalFeedback }}</p>
                <p class="text-sm text-blue-600 mt-1">Masukan masyarakat</p>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <p class="text-sm text-gray-600 mb-1">Kata Paling Sering</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $topWord['word'] ?? '-' }}</p>
                <p class="text-sm text-green-600 mt-1">{{ $topWord['count'] ?? 0 }} kali muncul</p>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <p class="text-sm text-gray-600 mb-1">Kategori Utama</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $kategoriUtama ?? '-' }}</p>
                <p class="text-sm text-purple-600 mt-1">Fokus utama feedback</p>
            </div>
        </div>

        {{-- WORD CLOUD --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <div class="flex items-center gap-2 mb-3">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                          d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v9a2 2 0 01-2 2h-4l-4 4z" />
                </svg>
                <h3 class="font-semibold text-gray-900">Word Cloud Feedback Masyarakat</h3>
            </div>
            <p class="text-sm text-gray-600 mb-4">
                Visualisasi kata yang paling sering muncul dari feedback masyarakat.
            </p>

            <div class="h-[400px] border border-gray-200 rounded-lg bg-gray-50 flex items-center justify-center">
                <canvas id="wordCloudCanvas"></canvas>
            </div>
        </div>

        {{-- TOP WORDS --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <h3 class="font-semibold text-gray-900 mb-4">10 Kata Paling Sering Muncul</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach($topWords as $index => $word)
                    <div class="bg-gradient-to-br from-blue-50 to-green-50 rounded-lg p-4 text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ $index + 1 }}</p>
                        <p class="text-lg font-semibold text-gray-900 mt-1">{{ $word['word'] }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $word['count'] }}x</p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- FEEDBACK LIST (CARD STYLE) --}}
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h3 class="font-semibold text-gray-900 mb-4">Daftar Feedback</h3>

            <div class="space-y-4">
                @forelse($feedbacks as $feedback)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                        <div class="flex justify-between mb-2">
                            <div>
                                <p class="font-semibold text-gray-900">
                                    {{ $feedback->user->name ?? 'Anonim' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    {{ $feedback->created_at->format('d M Y') }}
                                </p>
                            </div>

                            <span class="px-3 py-1 text-xs rounded-full font-medium
                                @if($feedback->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($feedback->status === 'diproses') bg-blue-100 text-blue-800
                                @else bg-green-100 text-green-800
                                @endif">
                                {{ ucfirst($feedback->status) }}
                            </span>
                        </div>

                        <p class="text-gray-700">
                            {{ $feedback->isi_feedback }}
                        </p>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-10">Belum ada feedback</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
