@extends('layouts.app')

@section('title', "O'sh Viloyati Masjidlari va Namoz Vaqtlari")

@section('content')
<!-- Hero Section with Islamic Background & Countdown Timer -->
<div class="relative bg-islamic-pattern text-white overflow-hidden py-12 lg:py-16 shadow-xl">
    <!-- Subtle gradient overlay -->
    <div class="absolute inset-0 bg-gradient-to-b from-emerald-950/80 via-emerald-900/90 to-emerald-950 pointer-events-none"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-8">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-400/20 text-amber-300 border border-amber-400/30 mb-4 backdrop-blur-xs">
                <svg class="w-3.5 h-3.5 text-amber-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C11.5 2 11 2.4 11 3C11 3.2 11.1 3.4 11.2 3.6C10.5 4.3 10 5.4 10 6.6C10 7.8 10.6 8.9 11.5 9.6C9.5 10.5 8 12.6 8 15V21H16V15C16 12.6 14.5 10.5 12.5 9.6C13.4 8.9 14 7.8 14 6.6C14 5.4 13.5 4.3 12.8 3.6C12.9 3.4 13 3.2 13 3C13 2.4 12.5 2 12 2Z"/></svg>
                O'sh viloyati va shahar masjidlari portali
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white mb-3">
                O'sh Viloyati <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-300 via-yellow-200 to-amber-400">Masjidlari va Namoz Vaqtlari</span>
            </h1>
            <p class="text-base sm:text-lg text-emerald-150/90 leading-relaxed font-light">
                Har bir masjidning haqiqiy jamoat (iqomat) vaqtlari, eng yaqin masjidni topish va interaktiv xarita.
            </p>
        </div>

        <!-- Central Live Countdown Widget -->
        <div class="max-w-2xl mx-auto bg-gradient-to-b from-white/10 to-white/5 backdrop-blur-md rounded-3xl p-6 sm:p-8 border border-white/15 shadow-2xl mb-10 text-center"
             x-data="countdownTimer({{ $nextPrayerInfo['target_timestamp'] }}, '{{ $nextPrayerInfo['name'] }}', '{{ $nextPrayerInfo['time'] }}')"
             x-init="start()">
            <div class="flex items-center justify-center gap-2 text-amber-300 text-xs sm:text-sm font-semibold tracking-wider uppercase mb-2">
                <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                <span>Keyingi Namoz Vaqti</span>
            </div>
            
            <div class="text-2xl sm:text-4xl font-extrabold text-white mb-4">
                <span x-text="prayerName">{{ $nextPrayerInfo['name'] }}</span>
                <span class="text-amber-300 ml-2" x-text="prayerTime">{{ $nextPrayerInfo['time'] }}</span>
            </div>

            <!-- Segmented countdown timer boxes -->
            <div class="grid grid-cols-3 gap-3 sm:gap-6 max-w-sm mx-auto mb-4">
                <div class="bg-emerald-950/70 border border-emerald-500/30 rounded-2xl p-3 sm:p-4 text-center">
                    <span class="block text-2xl sm:text-4xl font-black text-amber-300 tracking-tight" x-text="hours">00</span>
                    <span class="text-[10px] sm:text-xs text-emerald-200 uppercase font-medium">Soat</span>
                </div>
                <div class="bg-emerald-950/70 border border-emerald-500/30 rounded-2xl p-3 sm:p-4 text-center">
                    <span class="block text-2xl sm:text-4xl font-black text-amber-300 tracking-tight" x-text="minutes">00</span>
                    <span class="text-[10px] sm:text-xs text-emerald-200 uppercase font-medium">Daqiqa</span>
                </div>
                <div class="bg-emerald-950/70 border border-emerald-500/30 rounded-2xl p-3 sm:p-4 text-center">
                    <span class="block text-2xl sm:text-4xl font-black text-amber-300 tracking-tight" x-text="seconds">00</span>
                    <span class="text-[10px] sm:text-xs text-emerald-200 uppercase font-medium">Soniya</span>
                </div>
            </div>

            <p class="text-xs text-emerald-200/80">
                Bugungi sana: <strong class="text-white">{{ $now->translatedFormat('d-F, Y-yil (l)') }}</strong>
            </p>
        </div>

        <!-- Quick Action Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-3 sm:gap-4">
            <button type="button" 
                    id="findNearestBtn"
                    onclick="findNearestMosques()"
                    class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl text-sm font-bold text-slate-900 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-lg shadow-amber-500/20 active:scale-95 transition-all">
                <svg class="w-5 h-5 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Menga eng yaqin masjidlar (GPS)</span>
            </button>

            <a href="#karta" 
               class="inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl text-sm font-bold text-white bg-white/15 hover:bg-white/20 border border-white/20 backdrop-blur-md shadow-lg active:scale-95 transition-all">
                <svg class="w-5 h-5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                <span>Xaritada ko'rish</span>
            </a>
        </div>
    </div>
</div>

<!-- Main Body: Search, Filters, Map & Mosque Cards -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" id="masjidlar-bolimi">

    <!-- Search & Filter Header -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-sm border border-slate-200/80 mb-8">
        <form method="GET" action="{{ route('home') }}" class="flex flex-col md:flex-row items-center gap-4">
            <!-- Search bar -->
            <div class="relative w-full md:flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" 
                       name="search" 
                       value="{{ $search }}"
                       placeholder="Masjid nomi, manzil, mo'ljal yoki imom ismi..." 
                       class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-600 focus:bg-white transition-all">
                @if($selectedDistrict)
                    <input type="hidden" name="district" value="{{ $selectedDistrict }}">
                @endif
            </div>

            <!-- Filter submit & reset -->
            <div class="flex items-center gap-2 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none px-6 py-3 rounded-2xl text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-sm transition-all">
                    Qidirish
                </button>
                @if($search || $selectedDistrict)
                    <a href="{{ route('home') }}" class="px-4 py-3 rounded-2xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-all">
                        Tozalash
                    </a>
                @endif
            </div>
        </form>

        <!-- District Filter Pills -->
        <div class="mt-5 pt-5 border-t border-slate-100">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2.5">
                Tumanlar bo'yicha saralash:
            </span>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('home', array_merge(request()->except('district'), ['district' => 'all'])) }}"
                   class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ empty($selectedDistrict) || $selectedDistrict === 'all' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Barchasi ({{ $districts->sum('mosques_count') }})
                </a>
                @foreach($districts as $d)
                    <a href="{{ route('home', array_merge(request()->except('district'), ['district' => $d->slug])) }}"
                       class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $selectedDistrict === $d->slug ? 'bg-emerald-700 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ $d->name_uz }} ({{ $d->mosques_count }})
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- GPS Status Alert (Hidden by default, shows when locating) -->
    <div id="gpsNotice" class="hidden mb-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-sm flex items-center justify-between">
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-amber-500 animate-ping"></span>
            <span id="gpsMessage">Sizning joylashuvingiz aniqlanmoqda...</span>
        </div>
        <button onclick="document.getElementById('gpsNotice').classList.add('hidden')" class="text-amber-700 hover:text-amber-900 font-bold text-xs">
            Yopish
        </button>
    </div>

    <!-- SECTION 2: Interactive Leaflet Map (Stage 2) -->
    <div class="bg-white rounded-3xl p-5 sm:p-6 shadow-sm border border-slate-200/80 mb-10" id="karta">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="p-2 rounded-xl bg-emerald-100 text-emerald-800">
                        <svg class="w-5 h-5 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    </span>
                    <h2 class="text-xl sm:text-2xl font-bold text-slate-900">
                        O'sh Viloyati Masjidlari Xaritasi
                    </h2>
                </div>
                <p class="text-xs text-slate-500 mt-1">Xaritadagi minora belgisini bosib har bir masjidning joriy namoz vaqtini ko'ring</p>
            </div>
            <div class="flex items-center gap-2">
                <button type="button" 
                        onclick="locateOnMap()"
                        class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 transition-all">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Mening nuqtam
                </button>
            </div>
        </div>

        <!-- The Leaflet Map Container -->
        <div id="oshMosqueMap" class="w-full h-80 sm:h-[420px] rounded-2xl border border-slate-200 overflow-hidden z-10"></div>
    </div>

    <!-- Mosque Cards Grid -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-900">
                Masjidlar va Jamoat Vaqtlari
            </h2>
            <p class="text-xs text-slate-500 font-medium">Jami {{ $mosques->count() }} ta masjid ko'rsatilmoqda</p>
        </div>
    </div>

    @if($mosques->isEmpty())
        <div class="bg-white rounded-3xl p-12 text-center border border-slate-200">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 mx-auto flex items-center justify-center mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">Masjidlar topilmadi</h3>
            <p class="text-sm text-slate-500 mb-4">Qidiruv yoki tanlangan tuman bo'yicha hech qanday masjid mavjud emas.</p>
            <a href="{{ route('home') }}" class="inline-flex px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-emerald-700 hover:bg-emerald-800 transition-all">
                Barcha masjidlarni ko'rish
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="mosquesList">
            @foreach($mosques as $mosque)
                @php
                    $p = $mosque->prayerTimes;
                @endphp
                <div class="mosque-card bg-white rounded-3xl p-6 shadow-sm hover:shadow-md border border-slate-200/90 transition-all flex flex-col justify-between group"
                     data-id="{{ $mosque->id }}"
                     data-lat="{{ $mosque->latitude }}"
                     data-lng="{{ $mosque->longitude }}">
                    <div>
                        <!-- Header with District & Verification -->
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <span class="inline-block px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-800 border border-emerald-100">
                                {{ $mosque->district->name_uz }}
                            </span>

                            <!-- Distance badge placeholder (filled by JS if GPS active) -->
                            <span class="distance-badge hidden px-2.5 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                                -- km
                            </span>
                        </div>

                        <!-- Mosque Title & Address -->
                        <h3 class="text-lg font-bold text-slate-900 group-hover:text-emerald-700 transition-colors mb-1.5 leading-snug">
                            <a href="{{ route('mosque.show', $mosque->slug) }}">
                                {{ $mosque->name }}
                            </a>
                        </h3>
                        <p class="text-xs text-slate-500 mb-4 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="truncate">{{ $mosque->address }}</span>
                        </p>

                        <!-- Announcement if any -->
                        @if($p && $p->announcement)
                            <div class="mb-4 p-3 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-amber-950 text-xs flex items-start gap-2">
                                <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                                <span>{{ Str::limit($p->announcement, 90) }}</span>
                            </div>
                        @endif

                        <!-- Prayer Times Grid -->
                        <div class="bg-slate-50 rounded-2xl p-3 border border-slate-100 mb-4">
                            <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 uppercase tracking-wider pb-2 border-b border-slate-200/60 mb-2">
                                <span>Namoz</span>
                                <span>Azon</span>
                                <span class="text-emerald-800 font-extrabold">Jamoat</span>
                            </div>

                            <div class="space-y-1 text-xs">
                                <div class="flex items-center justify-between py-1 px-1.5 rounded-lg hover:bg-white transition-colors">
                                    <span class="font-medium text-slate-700">Bomdod</span>
                                    <span class="text-slate-400">{{ $p?->fajr_adhan ?? '--:--' }}</span>
                                    <span class="font-bold text-emerald-800 bg-emerald-100/70 px-2 py-0.5 rounded-md">{{ $p?->fajr_iqama ?? '--:--' }}</span>
                                </div>
                                <div class="flex items-center justify-between py-1 px-1.5 rounded-lg hover:bg-white transition-colors text-amber-700/80">
                                    <span class="font-medium">Quyosh</span>
                                    <span>--:--</span>
                                    <span class="font-semibold px-2 py-0.5">{{ $p?->sunrise ?? '--:--' }}</span>
                                </div>
                                <div class="flex items-center justify-between py-1 px-1.5 rounded-lg hover:bg-white transition-colors">
                                    <span class="font-medium text-slate-700">Peshin</span>
                                    <span class="text-slate-400">{{ $p?->dhuhr_adhan ?? '--:--' }}</span>
                                    <span class="font-bold text-emerald-800 bg-emerald-100/70 px-2 py-0.5 rounded-md">{{ $p?->dhuhr_iqama ?? '--:--' }}</span>
                                </div>
                                <div class="flex items-center justify-between py-1 px-1.5 rounded-lg hover:bg-white transition-colors">
                                    <span class="font-medium text-slate-700">Asr</span>
                                    <span class="text-slate-400">{{ $p?->asr_adhan ?? '--:--' }}</span>
                                    <span class="font-bold text-emerald-800 bg-emerald-100/70 px-2 py-0.5 rounded-md">{{ $p?->asr_iqama ?? '--:--' }}</span>
                                </div>
                                <div class="flex items-center justify-between py-1 px-1.5 rounded-lg hover:bg-white transition-colors">
                                    <span class="font-medium text-slate-700">Shom</span>
                                    <span class="text-slate-400">{{ $p?->maghrib_adhan ?? '--:--' }}</span>
                                    <span class="font-bold text-emerald-800 bg-emerald-100/70 px-2 py-0.5 rounded-md">{{ $p?->maghrib_iqama ?? '--:--' }}</span>
                                </div>
                                <div class="flex items-center justify-between py-1 px-1.5 rounded-lg hover:bg-white transition-colors">
                                    <span class="font-medium text-slate-700">Xufton</span>
                                    <span class="text-slate-400">{{ $p?->isha_adhan ?? '--:--' }}</span>
                                    <span class="font-bold text-emerald-800 bg-emerald-100/70 px-2 py-0.5 rounded-md">{{ $p?->isha_iqama ?? '--:--' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Amenities with SVG icons -->
                        <div class="flex items-center gap-3 text-[11px] text-slate-500 mb-4">
                            @if($mosque->has_ablution)
                                <span class="flex items-center gap-1.5 text-teal-700 bg-teal-50/80 px-2 py-0.5 rounded-md border border-teal-100" title="Tahoratxona mavjud">
                                    <svg class="w-3.5 h-3.5 text-teal-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                                    <span>Tahoratxona</span>
                                </span>
                            @endif
                            @if($mosque->has_women_area)
                                <span class="flex items-center gap-1.5 text-purple-700 bg-purple-50/80 px-2 py-0.5 rounded-md border border-purple-100" title="Ayollar namozxonasi mavjud">
                                    <svg class="w-3.5 h-3.5 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                                    <span>Ayollar xonasi</span>
                                </span>
                            @endif
                            @if($mosque->has_parking)
                                <span class="flex items-center gap-1.5 text-blue-700 bg-blue-50/80 px-2 py-0.5 rounded-md border border-blue-100" title="Avtoturargoh mavjud">
                                    <svg class="w-3.5 h-3.5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7h4a3 3 0 010 6H9"/></svg>
                                    <span>Parking</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Footer actions -->
                    <div class="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
                        <a href="{{ route('mosque.show', $mosque->slug) }}" class="flex-1 text-center py-2.5 px-3 rounded-xl text-xs font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                            Batafsil ko'rish
                        </a>
                        
                        @if($mosque->latitude && $mosque->longitude)
                            <a href="https://yandex.com/maps/?rtext=~{{ $mosque->latitude }},{{ $mosque->longitude }}&rtt=auto" 
                               target="_blank" 
                               title="Yandex Navigator orqali yo'nalish olish"
                               class="p-2.5 rounded-xl text-slate-600 hover:text-amber-600 hover:bg-amber-50 border border-slate-200 transition-colors flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // 1. Live Countdown Timer Alpine Component
    function countdownTimer(targetTimestamp, initialName, initialTime) {
        return {
            target: targetTimestamp * 1000,
            prayerName: initialName,
            prayerTime: initialTime,
            hours: '00',
            minutes: '00',
            seconds: '00',
            start() {
                this.update();
                setInterval(() => {
                    this.update();
                }, 1000);
            },
            update() {
                const now = new Date().getTime();
                let diff = this.target - now;

                if (diff <= 0) {
                    diff = 0;
                    this.hours = '00';
                    this.minutes = '00';
                    this.seconds = '00';
                    return;
                }

                const h = Math.floor((diff / (1000 * 60 * 60)));
                const m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((diff % (1000 * 60)) / 1000);

                this.hours = String(h).padStart(2, '0');
                this.minutes = String(m).padStart(2, '0');
                this.seconds = String(s).padStart(2, '0');
            }
        };
    }

    // 2. Leaflet Map Initialization (Stage 2)
    let mapInstance = null;
    let markersLayer = null;
    let userMarker = null;

    document.addEventListener('DOMContentLoaded', function () {
        initOshMap();
    });

    function initOshMap() {
        // Osh city coordinates: 40.5283, 72.7936
        const mapCenter = [40.5283, 72.7936];
        mapInstance = L.map('oshMosqueMap').setView(mapCenter, 11);

        // OpenStreetMap clean tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap O\'sh'
        }).addTo(mapInstance);

        markersLayer = L.layerGroup().addTo(mapInstance);

        // Fetch mosques API and add pins
        fetch('{{ route("api.mosques") }}')
            .then(res => res.json())
            .then(mosques => {
                window.allMosquesData = mosques;
                renderMapMarkers(mosques);
            })
            .catch(err => console.error("Xaritani yuklashda xatolik:", err));
    }

    function renderMapMarkers(mosques) {
        markersLayer.clearLayers();

        const customIcon = L.divIcon({
            className: 'custom-mosque-pin-container',
            html: `
                <div class="custom-mosque-pin w-9 h-9">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C11.5 2 11 2.4 11 3C11 3.2 11.1 3.4 11.2 3.6C10.5 4.3 10 5.4 10 6.6C10 7.8 10.6 8.9 11.5 9.6C9.5 10.5 8 12.6 8 15V21H16V15C16 12.6 14.5 10.5 12.5 9.6C13.4 8.9 14 7.8 14 6.6C14 5.4 13.5 4.3 12.8 3.6C12.9 3.4 13 3.2 13 3C13 2.4 12.5 2 12 2Z"/>
                    </svg>
                </div>
            `,
            iconSize: [36, 36],
            iconAnchor: [18, 18],
            popupAnchor: [0, -20]
        });

        mosques.forEach(m => {
            if (!m.latitude || !m.longitude) return;

            const p = m.prayer_times || {};
            const popupContent = `
                <div class="p-2 min-w-[220px]">
                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-100 text-emerald-800 mb-1">${m.district}</span>
                    <h4 class="font-bold text-sm text-slate-900 mb-1">${m.name}</h4>
                    <p class="text-[11px] text-slate-500 mb-2">${m.address}</p>

                    <div class="bg-slate-50 rounded-xl p-2 border border-slate-200 text-xs mb-2">
                        <div class="flex justify-between py-0.5"><span class="text-slate-500">Bomdod (jamoat):</span><strong class="text-emerald-800">${p.fajr_iqama || '--:--'}</strong></div>
                        <div class="flex justify-between py-0.5"><span class="text-slate-500">Peshin (jamoat):</span><strong class="text-emerald-800">${p.dhuhr_iqama || '--:--'}</strong></div>
                        <div class="flex justify-between py-0.5"><span class="text-slate-500">Asr (jamoat):</span><strong class="text-emerald-800">${p.asr_iqama || '--:--'}</strong></div>
                        <div class="flex justify-between py-0.5"><span class="text-slate-500">Shom (jamoat):</span><strong class="text-emerald-800">${p.maghrib_iqama || '--:--'}</strong></div>
                        <div class="flex justify-between py-0.5"><span class="text-slate-500">Xufton (jamoat):</span><strong class="text-emerald-800">${p.isha_iqama || '--:--'}</strong></div>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <a href="/masjid/${m.slug}" class="flex-1 text-center py-1.5 rounded-lg text-xs font-bold text-white bg-emerald-700 hover:bg-emerald-800">
                            Batafsil
                        </a>
                        <a href="https://yandex.com/maps/?rtext=~${m.latitude},${m.longitude}&rtt=auto" target="_blank" class="px-2 py-1.5 rounded-lg text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200" title="Navigator">
                            Yo'l
                        </a>
                    </div>
                </div>
            `;

            L.marker([m.latitude, m.longitude], { icon: customIcon })
                .bindPopup(popupContent)
                .addTo(markersLayer);
        });
    }

    // 3. Geolocation & Find Nearest Mosques
    function findNearestMosques() {
        const notice = document.getElementById('gpsNotice');
        const msg = document.getElementById('gpsMessage');
        notice.classList.remove('hidden');
        msg.textContent = "Sizning joylashuvingiz aniqlanmoqda...";

        if (!navigator.geolocation) {
            msg.textContent = "Brauzeringizda geolokatsiya xizmati qo'llab-quvvatlanmaydi.";
            return;
        }

        navigator.geolocation.getCurrentPosition(
            (pos) => {
                const userLat = pos.coords.latitude;
                const userLng = pos.coords.longitude;
                msg.innerHTML = `Joylashuvingiz aniqlandi! Koordinata: <strong>${userLat.toFixed(4)}, ${userLng.toFixed(4)}</strong>. Yaqin masjidlar saralandi.`;

                // Update Map
                if (mapInstance) {
                    if (userMarker) mapInstance.removeLayer(userMarker);
                    
                    const userIcon = L.divIcon({
                        className: 'user-pin-container',
                        html: '<div class="user-location-pin w-5 h-5"></div>',
                        iconSize: [20, 20]
                    });

                    userMarker = L.marker([userLat, userLng], { icon: userIcon })
                        .bindPopup("<strong>Sizning joylashuvingiz</strong>")
                        .addTo(mapInstance);

                    mapInstance.setView([userLat, userLng], 13);
                }

                // Sort Mosque Cards by distance
                calculateAndSortCards(userLat, userLng);
            },
            (err) => {
                console.warn(err);
                msg.textContent = "Geolokatsiyani aniqlashga ruxsat berilmadi yoki xatolik yuz berdi.";
            },
            { enableHighAccuracy: true, timeout: 10000 }
        );
    }

    function locateOnMap() {
        findNearestMosques();
        document.getElementById('karta').scrollIntoView({ behavior: 'smooth' });
    }

    function calculateAndSortCards(userLat, userLng) {
        const container = document.getElementById('mosquesList');
        if (!container) return;

        const cards = Array.from(container.getElementsByClassName('mosque-card'));

        cards.forEach(card => {
            const lat = parseFloat(card.dataset.lat);
            const lng = parseFloat(card.dataset.lng);

            if (!isNaN(lat) && !isNaN(lng)) {
                const distanceKm = getDistanceFromLatLonInKm(userLat, userLng, lat, lng);
                card.dataset.distance = distanceKm;

                const badge = card.querySelector('.distance-badge');
                if (badge) {
                    badge.classList.remove('hidden');
                    if (distanceKm < 1) {
                        badge.textContent = `${Math.round(distanceKm * 1000)} m uzoqlikda`;
                    } else {
                        badge.textContent = `${distanceKm.toFixed(1)} km uzoqlikda`;
                    }
                }
            } else {
                card.dataset.distance = 99999;
            }
        });

        // Reorder DOM
        cards.sort((a, b) => parseFloat(a.dataset.distance) - parseFloat(b.dataset.distance));
        cards.forEach(card => container.appendChild(card));
    }

    // Haversine formula for distance
    function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
        const R = 6371; // Radius of the earth in km
        const dLat = deg2rad(lat2 - lat1);
        const dLon = deg2rad(lon2 - lon1);
        const a =
            Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
            Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c;
    }

    function deg2rad(deg) {
        return deg * (Math.PI / 180);
    }
</script>
@endpush
