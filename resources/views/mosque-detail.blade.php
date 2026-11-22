@extends('layouts.app')

@section('title', $mosque->name . " — Namoz Vaqtlari")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 font-medium">
        <a href="{{ route('home') }}" class="hover:text-emerald-700 transition-colors">Bosh sahifa</a>
        <span>/</span>
        <a href="{{ route('home', ['district' => $mosque->district->slug]) }}" class="hover:text-emerald-700 transition-colors">{{ $mosque->district->name_uz }}</a>
        <span>/</span>
        <span class="text-slate-900 font-bold truncate">{{ $mosque->name }}</span>
    </nav>

    <!-- Header Card with Islamic Arch Styling -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border-t-4 border-t-emerald-700 border-x border-b border-slate-200/80 mb-8 relative overflow-hidden">
        <!-- Subtle gold line -->
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent"></div>
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="px-3 py-1 rounded-xl text-xs font-bold bg-emerald-100 text-emerald-800">
                        {{ $mosque->district->name_uz }}
                    </span>
                    @if($mosque->capacity)
                        <span class="px-3 py-1 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700">
                            Sig'imi: ~{{ number_format($mosque->capacity) }} kishi
                        </span>
                    @endif
                </div>
                <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
                    {{ $mosque->name }}
                </h1>
                <p class="text-sm text-slate-600 flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $mosque->address }}</span>
                    @if($mosque->landmark)
                        <span class="text-slate-400">({{ $mosque->landmark }})</span>
                    @endif
                </p>
            </div>

            <!-- Quick Navigation Buttons -->
            @if($mosque->latitude && $mosque->longitude)
                <div class="flex items-center gap-2">
                    <a href="https://yandex.com/maps/?rtext=~{{ $mosque->latitude }},{{ $mosque->longitude }}&rtt=auto"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold text-white bg-red-600 hover:bg-red-700 shadow-sm transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        Yandex Navigator
                    </a>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $mosque->latitude }},{{ $mosque->longitude }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl text-xs sm:text-sm font-bold text-slate-800 bg-slate-100 hover:bg-slate-200 border border-slate-200 transition-all">
                        Google Xarita
                    </a>
                </div>
            @endif
        </div>

        <!-- Announcement Alert if present -->
        @if($mosque->prayerTimes && $mosque->prayerTimes->announcement)
            <div class="mt-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-950 text-sm flex items-start gap-3">
                <div class="p-2 bg-amber-100 rounded-xl text-amber-700 flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-amber-900 mb-0.5">Masjid ma'muriyati e'loni:</h4>
                    <p class="leading-relaxed">{{ $mosque->prayerTimes->announcement }}</p>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Column: Full Prayer Times Table -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                            Bugungi 5 Vaqt Namoz Jadvali
                        </h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Oxirgi yangilangan: <span class="font-semibold text-emerald-800">{{ $mosque->prayerTimes?->updated_at?->diffForHumans() ?? 'Yaqinda' }}</span>
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Jamoat vaqtlari
                    </span>
                </div>

                @php $p = $mosque->prayerTimes; @endphp
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-bold text-slate-400 uppercase tracking-wider">
                                <th class="pb-3 pl-2">Namoz</th>
                                <th class="pb-3 text-center">Azon Vaqti</th>
                                <th class="pb-3 text-right pr-2">Jamoat (Iqomat)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 pl-2 font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                                    Bomdod
                                </td>
                                <td class="py-4 text-center font-medium text-slate-500">{{ $p?->fajr_adhan ?? '--:--' }}</td>
                                <td class="py-4 text-right pr-2 font-black text-xl text-emerald-800">{{ $p?->fajr_iqama ?? '--:--' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors bg-amber-50/40">
                                <td class="py-4 pl-2 font-bold text-amber-800 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                                    Quyosh chiqishi
                                </td>
                                <td class="py-4 text-center font-medium text-slate-400">--:--</td>
                                <td class="py-4 text-right pr-2 font-bold text-lg text-amber-800">{{ $p?->sunrise ?? '--:--' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 pl-2 font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
                                    Peshin
                                </td>
                                <td class="py-4 text-center font-medium text-slate-500">{{ $p?->dhuhr_adhan ?? '--:--' }}</td>
                                <td class="py-4 text-right pr-2 font-black text-xl text-emerald-800">{{ $p?->dhuhr_iqama ?? '--:--' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 pl-2 font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-orange-500"></span>
                                    Asr
                                </td>
                                <td class="py-4 text-center font-medium text-slate-500">{{ $p?->asr_adhan ?? '--:--' }}</td>
                                <td class="py-4 text-right pr-2 font-black text-xl text-emerald-800">{{ $p?->asr_iqama ?? '--:--' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 pl-2 font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                    Shom
                                </td>
                                <td class="py-4 text-center font-medium text-slate-500">{{ $p?->maghrib_adhan ?? '--:--' }}</td>
                                <td class="py-4 text-right pr-2 font-black text-xl text-emerald-800">{{ $p?->maghrib_iqama ?? '--:--' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 pl-2 font-bold text-slate-800 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-indigo-600"></span>
                                    Xufton
                                </td>
                                <td class="py-4 text-center font-medium text-slate-500">{{ $p?->isha_adhan ?? '--:--' }}</td>
                                <td class="py-4 text-right pr-2 font-black text-xl text-emerald-800">{{ $p?->isha_iqama ?? '--:--' }}</td>
                            </tr>
                            <tr class="hover:bg-emerald-50/50 transition-colors bg-emerald-50/30">
                                <td class="py-4 pl-2 font-extrabold text-emerald-900 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                                    Juma Namozi
                                </td>
                                <td class="py-4 text-center font-medium text-slate-500">Ma'ruza: {{ $p?->juma_bayan ?? '12:30' }}</td>
                                <td class="py-4 text-right pr-2 font-black text-xl text-emerald-900">Farz: {{ $p?->juma_iqama ?? '13:00' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Interactive Map Centered on this Mosque -->
            @if($mosque->latitude && $mosque->longitude)
                <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80">
                    <h3 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Masjidning Xaritadagi O'rni
                    </h3>
                    <div id="singleMosqueMap" class="w-full h-72 sm:h-80 rounded-2xl border border-slate-200"></div>
                </div>
            @endif
        </div>

        <!-- Sidebar: Info & Amenities -->
        <div class="space-y-6">
            <!-- Details Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
                <h3 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">
                    Masjid haqida ma'lumot
                </h3>
                <dl class="space-y-3.5 text-xs sm:text-sm">
                    @if($mosque->imam_name)
                        <div class="flex justify-between items-center">
                            <dt class="text-slate-500">Imom xatib:</dt>
                            <dd class="font-bold text-slate-800">{{ $mosque->imam_name }}</dd>
                        </div>
                    @endif
                    @if($mosque->phone)
                        <div class="flex justify-between items-center">
                            <dt class="text-slate-500">Aloqa telefoni:</dt>
                            <dd class="font-bold text-emerald-700">
                                <a href="tel:{{ $mosque->phone }}">{{ $mosque->phone }}</a>
                            </dd>
                        </div>
                    @endif
                    <div class="flex justify-between items-center">
                        <dt class="text-slate-500">Viloyat / Tuman:</dt>
                        <dd class="font-semibold text-slate-800">{{ $mosque->district->name_uz }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Amenities -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
                <h3 class="text-base font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100">
                    Mavjud Qulayliklar
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center gap-3 text-sm {{ $mosque->has_ablution ? 'text-teal-900 font-semibold' : 'text-slate-400' }}">
                        <span class="w-8 h-8 rounded-xl {{ $mosque->has_ablution ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                        </span>
                        <span>Tahoratxona (issiq/sovuq suv)</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm {{ $mosque->has_women_area ? 'text-purple-900 font-semibold' : 'text-slate-400' }}">
                        <span class="w-8 h-8 rounded-xl {{ $mosque->has_women_area ? 'bg-purple-50 text-purple-700' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                        </span>
                        <span>Ayollar namozxonasi</span>
                    </div>

                    <div class="flex items-center gap-3 text-sm {{ $mosque->has_parking ? 'text-blue-900 font-semibold' : 'text-slate-400' }}">
                        <span class="w-8 h-8 rounded-xl {{ $mosque->has_parking ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-400' }} flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7h4a3 3 0 010 6H9"/></svg>
                        </span>
                        <span>Avtoturargoh (Parking)</span>
                    </div>
                </div>
            </div>

            <!-- Visitor Notice -->
            <div class="bg-gradient-to-br from-emerald-950 to-slate-900 text-emerald-100 rounded-3xl p-6 shadow-sm border border-emerald-800/40">
                <span class="text-amber-400 text-xs font-bold uppercase tracking-wider block mb-2">Namozxonlar diqqatiga</span>
                <p class="text-xs text-emerald-200/80 leading-relaxed">
                    Masjid hududida telefonlarni ovozsiz rejimga o'tkazish, tahoratxonani toza saqlash hamda avtomashinalarni belgilangan joyga tartibli qo'yish so'raladi.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($mosque->latitude && $mosque->longitude)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $mosque->latitude }};
        const lng = {{ $mosque->longitude }};
        const map = L.map('singleMosqueMap').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        const customIcon = L.divIcon({
            className: 'custom-mosque-pin-container',
            html: `
                <div class="custom-mosque-pin w-10 h-10">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C11.5 2 11 2.4 11 3C11 3.2 11.1 3.4 11.2 3.6C10.5 4.3 10 5.4 10 6.6C10 7.8 10.6 8.9 11.5 9.6C9.5 10.5 8 12.6 8 15V21H16V15C16 12.6 14.5 10.5 12.5 9.6C13.4 8.9 14 7.8 14 6.6C14 5.4 13.5 4.3 12.8 3.6C12.9 3.4 13 3.2 13 3C13 2.4 12.5 2 12 2Z"/>
                    </svg>
                </div>
            `,
            iconSize: [40, 40],
            iconAnchor: [20, 20]
        });

        L.marker([lat, lng], { icon: customIcon })
            .bindPopup("<strong>{{ $mosque->name }}</strong><br>{{ $mosque->address }}")
            .openPopup()
            .addTo(map);
    });
</script>
@endif
@endpush
