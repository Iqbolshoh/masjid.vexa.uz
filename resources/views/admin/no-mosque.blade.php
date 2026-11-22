@extends('layouts.app')

@section('title', "Masjid Biriktirilmagan")

@section('content')
<div class="max-w-md mx-auto px-4 py-16 text-center">
    <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
        <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 mx-auto flex items-center justify-center mb-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <h2 class="text-xl font-bold text-slate-800 mb-2">Masjid Biriktirilmagan</h2>
        <p class="text-xs text-slate-500 mb-6 leading-relaxed">
            Sizning hisobingizga hali birorta ham masjid biriktirilmagan. Iltimos, bosh administrator bilan bog'laning.
        </p>
        <a href="{{ route('home') }}" class="inline-flex px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800">
            Bosh sahifaga qaytish
        </a>
    </div>
</div>
@endsection
