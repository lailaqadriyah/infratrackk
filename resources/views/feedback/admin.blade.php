@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Rekap Feedback</h1>

        @if($feedbacks->count() > 0)
            <div class="space-y-4">
                @foreach($feedbacks as $feedback)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $feedback->user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $feedback->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="mt-3">
                            <p class="text-gray-700">{{ $feedback->isi_feedback }}</p>
                        </div>

                        @if($feedback->file_path)
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-700 mb-2">File Terlampir:</p>
                                @if(strpos($feedback->file_path, '.pdf') !== false || strpos($feedback->file_path, '.doc') !== false || strpos($feedback->file_path, '.docx') !== false)
                                    <a href="{{ asset('storage/' . $feedback->file_path) }}" target="_blank" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Lihat File
                                    </a>
                                @else
                                    <img src="{{ asset('storage/' . $feedback->file_path) }}" alt="Feedback Image" class="max-w-full h-auto max-h-64 rounded-lg shadow-sm border">
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Belum ada feedback yang dikirim.</p>
        @endif
    </div>
</div>
@endsection