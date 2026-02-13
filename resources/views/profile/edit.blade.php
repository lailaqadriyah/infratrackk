@extends('layouts.app')

@section('header', 'Profil')
@section('page-title', 'Profil')
@section('header_description', 'Kelola informasi akun Anda')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex items-center gap-4">
            <div class="h-14 w-14 rounded-full bg-blue-600 text-white flex items-center justify-center text-lg font-semibold">
                {{ substr(Auth::user()->name, 0, 1) }}
            </div>
            <div class="min-w-0">
                <p class="text-lg font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-600 truncate">{{ Auth::user()->email }}</p>
                <p class="text-xs text-gray-500 uppercase tracking-wide mt-1">
                    {{ optional(Auth::user()->role)->nama_role ?? 'Masyarakat' }}
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
