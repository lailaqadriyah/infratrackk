@php
	$routeName = request()->route()?->getName();
	$level = 1;
	if($routeName === 'user.apbd.index') {
		$level = 1;
	} elseif($routeName === 'user.apbd.program') {
		$level = 2;
	} elseif($routeName === 'user.apbd.kegiatan') {
		$level = 3;
	}
	$displayProgram = $program ?? 'Program';
	$displayKegiatan = $kegiatan ?? 'Kegiatan';
	$displaySub = $sub ?? 'Sub Kegiatan';
@endphp

<div class="mb-4">
	<div class="flex items-center justify-start gap-4">
		<nav class="flex items-center gap-2 text-sm">
			<a href="{{ route('user.apbd.index') }}" class="font-medium {{ $level >= 1 ? 'text-blue-600' : 'text-gray-400' }}">{{ $displayProgram }}</a>
			<svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
			@if(isset($program))
				<a href="{{ route('user.apbd.program', urlencode($program)) }}" class="font-medium {{ $level >= 2 ? 'text-blue-600' : 'text-gray-400' }}">{{ $displayKegiatan }}</a>
			@else
				<span class="font-medium text-gray-400">{{ $displayKegiatan }}</span>
			@endif
			<svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
			@if(isset($program) && isset($kegiatan))
				<a href="{{ route('user.apbd.kegiatan', [urlencode($program), urlencode($kegiatan)]) }}" class="font-medium {{ $level >= 3 ? 'text-blue-600' : 'text-gray-400' }}">{{ $displaySub }}</a>
			@else
				<span class="font-medium text-gray-400">{{ $displaySub }}</span>
			@endif
		</nav>

        
	</div>
</div>

