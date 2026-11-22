@extends('layouts.app')

@section('title', "Superadmin Boshqaruv Markazi")

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ showAddModal: false }">
    <!-- Header -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-3 py-1 rounded-xl text-xs font-bold bg-slate-900 text-amber-300">
                    Bosh Administrator
                </span>
                <span class="px-3 py-1 rounded-xl text-xs font-semibold bg-emerald-100 text-emerald-800">
                    O'sh viloyati tizimi
                </span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Superadmin Boshqaruv Paneli
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Barcha tumanlar, masjidlar va masjid adminlarini markazlashgan boshqarish
            </p>
        </div>

        <button type="button" 
                @click="showAddModal = true"
                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-md shadow-emerald-800/20 active:scale-95 transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Yangi Masjid Qo'shish
        </button>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Jami Masjidlar</span>
            <span class="text-3xl font-extrabold text-slate-900">{{ $mosques->count() }} ta</span>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Masjid Adminlari</span>
            <span class="text-3xl font-extrabold text-emerald-700">{{ $admins->count() }} nafar</span>
        </div>
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200/80">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-1">Qamrab Olingan Tumanlar</span>
            <span class="text-3xl font-extrabold text-amber-600">{{ $districts->count() }} ta</span>
        </div>
    </div>

    <!-- Mosques Table -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200/80 mb-8">
        <h2 class="text-xl font-extrabold text-slate-900 mb-6">
            Ro'yxatdan O'tgan Masjidlar
        </h2>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b border-slate-200 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <th class="pb-3 pl-2">Masjid Nomi</th>
                        <th class="pb-3">Tuman</th>
                        <th class="pb-3">Biriktirilgan Admin</th>
                        <th class="pb-3">Iqomat Vaqtlari (B / P / A / Sh / X)</th>
                        <th class="pb-3 text-right pr-2">Harakatlar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach($mosques as $m)
                        @php $p = $m->prayerTimes; @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 pl-2 font-bold text-slate-900">
                                <a href="{{ route('mosque.show', $m->slug) }}" class="hover:text-emerald-700 transition-colors">
                                    {{ $m->name }}
                                </a>
                                <span class="block text-xs font-normal text-slate-400">{{ $m->address }}</span>
                            </td>
                            <td class="py-4 font-semibold text-slate-700">
                                <span class="px-2.5 py-1 rounded-lg text-xs bg-slate-100">{{ $m->district->name_uz }}</span>
                            </td>
                            <td class="py-4 text-xs">
                                @if($m->admin)
                                    <div class="font-bold text-slate-800">{{ $m->admin->name }}</div>
                                    <div class="text-slate-400">{{ $m->admin->email }}</div>
                                @else
                                    <span class="text-red-500 font-semibold">Biriktirilmagan</span>
                                @endif
                            </td>
                            <td class="py-4 text-xs font-mono font-bold text-emerald-800">
                                {{ $p?->fajr_iqama ?? '--' }} • {{ $p?->dhuhr_iqama ?? '--' }} • {{ $p?->asr_iqama ?? '--' }} • {{ $p?->maghrib_iqama ?? '--' }} • {{ $p?->isha_iqama ?? '--' }}
                            </td>
                            <td class="py-4 text-right pr-2">
                                <a href="{{ route('mosque.show', $m->slug) }}" target="_blank" class="px-3 py-1.5 rounded-xl text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 transition-colors">
                                    Ko'rish
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal: Add New Mosque & Admin -->
    <div x-show="showAddModal" 
         x-transition 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" 
         style="display: none;">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-4 mb-6 border-b border-slate-100">
                <h3 class="text-lg font-bold text-slate-900">Yangi Masjid va Admin Qo'shish</h3>
                <button type="button" @click="showAddModal = false" class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <form action="{{ route('superadmin.mosques.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Tuman / Shahar</label>
                    <select name="district_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm">
                        @foreach($districts as $d)
                            <option value="{{ $d->id }}">{{ $d->name_uz }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Masjid Nomi</label>
                    <input type="text" name="name" required placeholder="Masalan: Yangi Jome Masjidi" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Manzil</label>
                    <input type="text" name="address" required placeholder="Ko'cha, uy raqami" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Imom Ismi</label>
                        <input type="text" name="imam_name" placeholder="Imom xatib" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Telefon</label>
                        <input type="text" name="phone" placeholder="+996 555..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Kenglik (Latitude)</label>
                        <input type="text" name="latitude" placeholder="40.5283" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-slate-700 mb-1">Uzunlik (Longitude)</label>
                        <input type="text" name="longitude" placeholder="72.7936" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-mono">
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <span class="block text-xs font-bold uppercase text-emerald-800 mb-2">Masjid Mas'uli (Admin) Hisobi</span>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1">Admin Ism-sharifi</label>
                            <input type="text" name="admin_name" required placeholder="Masjid mas'uli" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1">Admin Email (Kirish uchun login)</label>
                            <input type="email" name="admin_email" required placeholder="masjid@vexa.uz" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 mb-1">Admin Paroli</label>
                            <input type="password" name="admin_password" required minlength="6" placeholder="Parol (kamida 6 belgi)" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3">
                    <button type="button" @click="showAddModal = false" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200">
                        Bekor qilish
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800">
                        Saqlash va Yaratish
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
