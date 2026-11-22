@extends('layouts.app')

@section('title', "Masjid Admin Paneli — " . $mosque->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ activeTab: 'times' }">
    <!-- Top Bar with Mosque Name -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-3 py-1 rounded-xl text-xs font-bold bg-emerald-100 text-emerald-800">
                    {{ $mosque->district->name_uz }}
                </span>
                <span class="px-3 py-1 rounded-xl text-xs font-semibold bg-slate-100 text-slate-700">
                    Admin: {{ $user->name }}
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                {{ $mosque->name }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Masjid namoz vaqtlari va ma'lumotlarini to'g'irlash boshqaruvi
            </p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('mosque.show', $mosque->slug) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-all">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Saytda ko'rish
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex items-center gap-2 border-b border-slate-200 mb-8 overflow-x-auto pb-2">
        <button type="button" 
                @click="activeTab = 'times'"
                :class="activeTab === 'times' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100'"
                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            5 Vaqt Namoz Vaqtlari
        </button>

        <button type="button" 
                @click="activeTab = 'info'"
                :class="activeTab === 'info' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100'"
                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            Masjid Ma'lumotlari & Karta
        </button>

        <button type="button" 
                @click="activeTab = 'logs'"
                :class="activeTab === 'logs' ? 'bg-emerald-700 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100'"
                class="px-5 py-2.5 rounded-2xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            O'zgarishlar Tarixi
        </button>
    </div>

    <!-- TAB 1: PRAYER TIMES FORM -->
    <div x-show="activeTab === 'times'" class="space-y-6">
        @php $p = $mosque->prayerTimes; @endphp
        <form action="{{ route('admin.prayer-times.update', $mosque->id) }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80">
            @csrf
            
            <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">
                        Jamoat va Azon Vaqtlarini Tahrirlash
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Vaqtlarni kiritib "Saqlash" tugmasini bosing, ular bir zumda barcha odamlar uchun yangilanadi.
                    </p>
                </div>
                <button type="submit" class="px-6 py-3 rounded-2xl text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-md shadow-emerald-800/20 active:scale-95 transition-all">
                    Vaqtlarni Saqlash
                </button>
            </div>

            <!-- 5 Prayers Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <!-- Bomdod -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-200/70">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                        <h3 class="font-bold text-slate-800 text-sm">Bomdod Namozi</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-500 mb-1">Azon Vaqti</label>
                            <input type="time" name="fajr_adhan" value="{{ old('fajr_adhan', $p?->fajr_adhan ?? '05:55') }}" required
                                   class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-emerald-800 mb-1">Jamoat (Iqomat) Vaqti</label>
                            <input type="time" name="fajr_iqama" value="{{ old('fajr_iqama', $p?->fajr_iqama ?? '06:25') }}" required
                                   class="w-full px-3 py-2 bg-emerald-50 border border-emerald-300 rounded-xl text-base font-bold text-emerald-900">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-amber-700 mb-1">Quyosh chiqishi</label>
                            <input type="time" name="sunrise" value="{{ old('sunrise', $p?->sunrise ?? '07:22') }}" required
                                   class="w-full px-3 py-2 bg-amber-50/50 border border-amber-200 rounded-xl text-sm font-semibold text-amber-900">
                        </div>
                    </div>
                </div>

                <!-- Peshin -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-200/70">
                        <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                        <h3 class="font-bold text-slate-800 text-sm">Peshin Namozi</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-500 mb-1">Azon Vaqti</label>
                            <input type="time" name="dhuhr_adhan" value="{{ old('dhuhr_adhan', $p?->dhuhr_adhan ?? '12:45') }}" required
                                   class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-emerald-800 mb-1">Jamoat (Iqomat) Vaqti</label>
                            <input type="time" name="dhuhr_iqama" value="{{ old('dhuhr_iqama', $p?->dhuhr_iqama ?? '13:00') }}" required
                                   class="w-full px-3 py-2 bg-emerald-50 border border-emerald-300 rounded-xl text-base font-bold text-emerald-900">
                        </div>
                    </div>
                </div>

                <!-- Asr -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-200/70">
                        <span class="w-3 h-3 rounded-full bg-orange-500"></span>
                        <h3 class="font-bold text-slate-800 text-sm">Asr Namozi</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-500 mb-1">Azon Vaqti</label>
                            <input type="time" name="asr_adhan" value="{{ old('asr_adhan', $p?->asr_adhan ?? '15:15') }}" required
                                   class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-emerald-800 mb-1">Jamoat (Iqomat) Vaqti</label>
                            <input type="time" name="asr_iqama" value="{{ old('asr_iqama', $p?->asr_iqama ?? '15:30') }}" required
                                   class="w-full px-3 py-2 bg-emerald-50 border border-emerald-300 rounded-xl text-base font-bold text-emerald-900">
                        </div>
                    </div>
                </div>

                <!-- Shom -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-200/70">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span>
                        <h3 class="font-bold text-slate-800 text-sm">Shom Namozi</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-500 mb-1">Azon Vaqti</label>
                            <input type="time" name="maghrib_adhan" value="{{ old('maghrib_adhan', $p?->maghrib_adhan ?? '17:08') }}" required
                                   class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-emerald-800 mb-1">Jamoat (Iqomat) Vaqti</label>
                            <input type="time" name="maghrib_iqama" value="{{ old('maghrib_iqama', $p?->maghrib_iqama ?? '17:15') }}" required
                                   class="w-full px-3 py-2 bg-emerald-50 border border-emerald-300 rounded-xl text-base font-bold text-emerald-900">
                        </div>
                    </div>
                </div>

                <!-- Xufton -->
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200">
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-slate-200/70">
                        <span class="w-3 h-3 rounded-full bg-indigo-600"></span>
                        <h3 class="font-bold text-slate-800 text-sm">Xufton Namozi</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-500 mb-1">Azon Vaqti</label>
                            <input type="time" name="isha_adhan" value="{{ old('isha_adhan', $p?->isha_adhan ?? '18:40') }}" required
                                   class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-emerald-800 mb-1">Jamoat (Iqomat) Vaqti</label>
                            <input type="time" name="isha_iqama" value="{{ old('isha_iqama', $p?->isha_iqama ?? '19:00') }}" required
                                   class="w-full px-3 py-2 bg-emerald-50 border border-emerald-300 rounded-xl text-base font-bold text-emerald-900">
                        </div>
                    </div>
                </div>

                <!-- Juma -->
                <div class="p-5 rounded-2xl bg-emerald-50/50 border border-emerald-200">
                    <div class="flex items-center gap-2 mb-4 pb-2 border-b border-emerald-200">
                        <span class="w-3 h-3 rounded-full bg-emerald-600"></span>
                        <h3 class="font-bold text-emerald-900 text-sm">Juma Namozi</h3>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-slate-500 mb-1">Ma'ruza (Bayan) Vaqti</label>
                            <input type="time" name="juma_bayan" value="{{ old('juma_bayan', $p?->juma_bayan ?? '12:30') }}"
                                   class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-sm font-semibold">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-emerald-800 mb-1">Juma Farzi (Iqomat)</label>
                            <input type="time" name="juma_iqama" value="{{ old('juma_iqama', $p?->juma_iqama ?? '13:00') }}"
                                   class="w-full px-3 py-2 bg-white border border-emerald-300 rounded-xl text-base font-bold text-emerald-900">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Announcement textarea -->
            <div class="p-5 rounded-2xl bg-amber-50/60 border border-amber-200 mb-8">
                <label class="block text-xs font-bold uppercase text-amber-900 mb-2">
                    Masjid Jamoati Uchun E'lon (Ixtiyoriy)
                </label>
                <textarea name="announcement" rows="3" 
                          placeholder="Masalan: Keyingi haftadan bomdod jamoat vaqti 06:40 ga ko'chiriladi yoki tahoratxona ta'mirlanmoqda..."
                          class="w-full px-4 py-3 bg-white border border-amber-300 rounded-2xl text-sm focus:ring-2 focus:ring-amber-500 focus:outline-hidden">{{ old('announcement', $p?->announcement) }}</textarea>
                <p class="text-[11px] text-amber-800/80 mt-1">Ushbu e'lon saytdagi masjid sahifasida va masjid kartasida ko'rinadi.</p>
            </div>

            <div class="text-right">
                <button type="submit" class="px-8 py-3.5 rounded-2xl text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-md shadow-emerald-800/20 active:scale-95 transition-all">
                    O'zgarishlarni Saqlash
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 2: MOSQUE INFO & INTERACTIVE MAP PICKER -->
    <div x-show="activeTab === 'info'" class="space-y-6" style="display: none;">
        <form action="{{ route('admin.details.update', $mosque->id) }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80">
            @csrf

            <div class="flex items-center justify-between pb-6 mb-6 border-b border-slate-100">
                <div>
                    <h2 class="text-xl font-extrabold text-slate-900">
                        Masjid Ma'lumotlari & Xaritadagi Joylashuv
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">
                        Xaritadagi joylashuv (koordinatalar) odamlar GPS orqali masofani hisoblashi uchun ishlatiladi.
                    </p>
                </div>
                <button type="submit" class="px-6 py-3 rounded-2xl text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-md transition-all">
                    Ma'lumotlarni Saqlash
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Manzil</label>
                    <input type="text" name="address" value="{{ old('address', $mosque->address) }}" required
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Mo'ljal (Landmark)</label>
                    <input type="text" name="landmark" value="{{ old('landmark', $mosque->landmark) }}"
                           placeholder="Masalan: Sulaymon tog'i etagi yoki Markaziy bozor ro'parasi"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Imom Xatib Ismi</label>
                    <input type="text" name="imam_name" value="{{ old('imam_name', $mosque->imam_name) }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1.5">Aloqa Telefoni</label>
                    <input type="text" name="phone" value="{{ old('phone', $mosque->phone) }}"
                           placeholder="+996 555 123 456"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm">
                </div>
            </div>

            <!-- Amenities Checkboxes -->
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 mb-8">
                <span class="block text-xs font-bold uppercase text-slate-700 mb-3">Mavjud Qulayliklar:</span>
                <div class="flex flex-wrap gap-6 text-sm">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-800">
                        <input type="checkbox" name="has_ablution" value="1" {{ $mosque->has_ablution ? 'checked' : '' }}
                               class="rounded-sm border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                        <span class="flex items-center gap-1.5 text-teal-800">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2.69l5.66 5.66a8 8 0 11-11.31 0z"/></svg>
                            Tahoratxona
                        </span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-800">
                        <input type="checkbox" name="has_women_area" value="1" {{ $mosque->has_women_area ? 'checked' : '' }}
                               class="rounded-sm border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                        <span class="flex items-center gap-1.5 text-purple-800">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                            Ayollar namozxonasi
                        </span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer font-medium text-slate-800">
                        <input type="checkbox" name="has_parking" value="1" {{ $mosque->has_parking ? 'checked' : '' }}
                               class="rounded-sm border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4">
                        <span class="flex items-center gap-1.5 text-blue-800">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="4" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7h4a3 3 0 010 6H9"/></svg>
                            Avtoturargoh
                        </span>
                    </label>
                </div>
            </div>

            <!-- Interactive Map Picker (Stage 2 Feature) -->
            <div class="p-5 rounded-2xl bg-emerald-50/40 border border-emerald-200 mb-8">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Xaritadan Nuqtani Tanlash (Koordinatalar)</h4>
                        <p class="text-xs text-slate-500">Xarita ustiga bosing, pin avtomatik ko'chadi va koordinatalar saqlanadi.</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-[11px] font-bold uppercase text-slate-500 mb-1">Kenglik (Latitude)</label>
                        <input type="text" id="pickerLat" name="latitude" value="{{ old('latitude', $mosque->latitude ?? '40.5283') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-mono">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold uppercase text-slate-500 mb-1">Uzunlik (Longitude)</label>
                        <input type="text" id="pickerLng" name="longitude" value="{{ old('longitude', $mosque->longitude ?? '72.7936') }}"
                               class="w-full px-3 py-2 bg-white border border-slate-300 rounded-xl text-xs font-mono">
                    </div>
                </div>

                <div id="adminPickerMap" class="w-full h-80 rounded-2xl border border-slate-300"></div>
            </div>

            <div class="text-right">
                <button type="submit" class="px-8 py-3.5 rounded-2xl text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-md transition-all">
                    Barcha Ma'lumotlarni Saqlash
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 3: LOGS -->
    <div x-show="activeTab === 'logs'" class="space-y-6" style="display: none;">
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80">
            <h2 class="text-xl font-extrabold text-slate-900 mb-4">
                O'zgarishlar Tarixi (Audit Log)
            </h2>

            @if($mosque->logs->isEmpty())
                <p class="text-xs text-slate-400 py-6 text-center">Hali hech qanday o'zgarishlar tarixi mavjud emas.</p>
            @else
                <div class="divide-y divide-slate-100 text-xs">
                    @foreach($mosque->logs as $log)
                        <div class="py-3 flex items-center justify-between">
                            <div>
                                <span class="font-bold text-slate-800">{{ $log->user->name ?? 'Admin' }}</span>
                                <span class="text-slate-500 ml-2">{{ $log->comment }}</span>
                            </div>
                            <span class="text-slate-400 font-mono">{{ $log->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let pickerMap = null;
    let pickerMarker = null;

    document.addEventListener('DOMContentLoaded', function () {
        // Init picker map when tab switches or immediately
        setTimeout(() => {
            initPickerMap();
        }, 300);
    });

    function initPickerMap() {
        const latInput = document.getElementById('pickerLat');
        const lngInput = document.getElementById('pickerLng');

        let initialLat = parseFloat(latInput.value) || 40.5283;
        let initialLng = parseFloat(lngInput.value) || 72.7936;

        pickerMap = L.map('adminPickerMap').setView([initialLat, initialLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap'
        }).addTo(pickerMap);

        pickerMarker = L.marker([initialLat, initialLng], { draggable: true }).addTo(pickerMap);

        // Update inputs on drag
        pickerMarker.on('dragend', function (e) {
            const pos = e.target.getLatLng();
            latInput.value = pos.lat.toFixed(6);
            lngInput.value = pos.lng.toFixed(6);
        });

        // Click map to move marker
        pickerMap.on('click', function (e) {
            pickerMarker.setLatLng(e.latlng);
            latInput.value = e.latlng.lat.toFixed(6);
            lngInput.value = e.latlng.lng.toFixed(6);
        });
    }
</script>
@endpush
