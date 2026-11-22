@extends('layouts.app')

@section('title', "Boshqaruv Tizimiga Kirish")

@section('content')
<div class="max-w-md mx-auto px-4 py-12 sm:py-16">
    <div class="bg-white rounded-3xl p-8 sm:p-10 shadow-lg border-t-4 border-t-emerald-700 border-x border-b border-slate-200/80 relative overflow-hidden">
        
        <!-- Subtle gold line -->
        <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent"></div>

        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-700 to-emerald-900 text-amber-300 mx-auto flex items-center justify-center shadow-lg shadow-emerald-900/20 mb-4 border border-emerald-600/30">
                <svg class="w-9 h-9" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C11.5 2 11 2.4 11 3C11 3.2 11.1 3.4 11.2 3.6C10.5 4.3 10 5.4 10 6.6C10 7.8 10.6 8.9 11.5 9.6C9.5 10.5 8 12.6 8 15V21H16V15C16 12.6 14.5 10.5 12.5 9.6C13.4 8.9 14 7.8 14 6.6C14 5.4 13.5 4.3 12.8 3.6C12.9 3.4 13 3.2 13 3C13 2.4 12.5 2 12 2Z"/>
                </svg>
            </div>
            
            <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200 mb-2">
                Yagona Kirish Portali
            </span>

            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Boshqaruv Tizimi
            </h1>
            <p class="text-xs text-slate-500 mt-1">
                Masjid mas'ullari va Bosh administrator uchun yagona kirish
            </p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-xs">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Elektron pochta (Email)
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       required 
                       autofocus
                       placeholder="admin@osh-masjid.kg"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-600 focus:bg-white transition-all">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Parol
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required
                       placeholder="••••••••"
                       class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:outline-hidden focus:ring-2 focus:ring-emerald-600 focus:bg-white transition-all">
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="rounded-sm border-slate-300 text-emerald-600 focus:ring-emerald-500">
                    <span>Eslab qolish</span>
                </label>
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-3.5 px-6 rounded-2xl text-sm font-bold text-slate-900 bg-amber-400 hover:bg-amber-300 shadow-md shadow-amber-400/20 active:scale-95 transition-all">
                    Tizimga Kirish
                </button>
            </div>
        </form>

        <!-- Demo accounts preview box for testing -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-2 text-center">
                Sinov uchun hisoblar (Demo):
            </span>
            <div class="bg-slate-50 rounded-2xl p-3.5 border border-slate-200 text-xs space-y-2 text-slate-600">
                <div class="flex justify-between items-center pb-1.5 border-b border-slate-200/60">
                    <div>
                        <span class="font-bold text-slate-800 block">Sulaymon-Too masjidi</span>
                        <span class="text-[10px] text-slate-400">Masjid admin roli</span>
                    </div>
                    <button type="button" onclick="fillForm('sulaymon@osh-masjid.kg', 'masjid123')" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition-colors">
                        To'ldirish
                    </button>
                </div>
                <div class="flex justify-between items-center pb-1.5 border-b border-slate-200/60">
                    <div>
                        <span class="font-bold text-slate-800 block">Imom Buxoriy masjidi</span>
                        <span class="text-[10px] text-slate-400">Masjid admin roli</span>
                    </div>
                    <button type="button" onclick="fillForm('buxoriy@osh-masjid.kg', 'masjid123')" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-100 text-emerald-800 hover:bg-emerald-200 transition-colors">
                        To'ldirish
                    </button>
                </div>
                <div class="flex justify-between items-center">
                    <div>
                        <span class="font-bold text-slate-800 block">Superadmin</span>
                        <span class="text-[10px] text-amber-700 font-semibold">Bosh administrator roli</span>
                    </div>
                    <button type="button" onclick="fillForm('admin@osh-masjid.kg', 'admin12345')" class="px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-100 text-amber-900 hover:bg-amber-200 transition-colors">
                        To'ldirish
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function fillForm(email, pass) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = pass;
    }
</script>
@endsection
