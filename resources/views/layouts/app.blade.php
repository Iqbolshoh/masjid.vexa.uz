<!DOCTYPE html>
<html lang="uz" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#064e3b">
    <title>@yield('title', "O'sh Viloyati Masjidlari va Namoz Vaqtlari") | masjid.vexa.uz</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:ital,wght@0,400;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .font-quran {
            font-family: 'Amiri', serif;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex flex-col selection:bg-emerald-600 selection:text-white">

    <!-- Top Announcement Bar / Islamic Banner -->
    <div class="bg-gradient-to-r from-emerald-950 via-emerald-900 to-emerald-950 text-emerald-200 text-xs py-2 px-4 border-b border-emerald-800/40">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2">
                <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <span class="font-medium text-emerald-100">Qirg'iziston, O'sh viloyati va shahar jome masjidlari</span>
                <span class="hidden md:inline text-emerald-400/60">•</span>
                <span class="hidden md:inline text-emerald-300">Har bir masjid o'z jamoat (iqomat) vaqtini mustaqil belgilaydi</span>
            </div>
            <div class="flex items-center gap-4 text-emerald-300/90 font-medium">
                <div id="liveClock" class="flex items-center gap-1.5 bg-emerald-800/50 px-2.5 py-0.5 rounded-full border border-emerald-700/50">
                    <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span id="currentTimeDisplay">--:--:--</span>
                    <span class="text-[10px] text-amber-300/80 uppercase font-semibold">O'sh (UTC+6)</span>
                </div>
                <div class="hidden sm:flex items-center gap-1 text-emerald-200 text-xs font-quran text-sm">
                    <span>13 Jumada al-awwal 1448 H</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-xs transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3.5 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 flex items-center justify-center text-amber-300 shadow-md shadow-emerald-900/20 group-hover:scale-105 transition-transform">
                    <!-- Mosque Dome & Crescent SVG -->
                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C11.5 2 11 2.4 11 3C11 3.2 11.1 3.4 11.2 3.6C10.5 4.3 10 5.4 10 6.6C10 7.8 10.6 8.9 11.5 9.6C9.5 10.5 8 12.6 8 15V21H16V15C16 12.6 14.5 10.5 12.5 9.6C13.4 8.9 14 7.8 14 6.6C14 5.4 13.5 4.3 12.8 3.6C12.9 3.4 13 3.2 13 3C13 2.4 12.5 2 12 2M12 4C12.5 4 12.9 4.3 13 4.7C12.4 4.3 11.6 4.3 11 4.7C11.1 4.3 11.5 4 12 4M12 6C12.6 6 13 6.4 13 7C13 7.6 12.6 8 12 8C11.4 8 11 7.6 11 7C11 6.4 11.4 6 12 6M10 16H14V20H10V16M4 17H6V21H4V17M18 17H20V21H18V17M5 11L6 16H4L5 11M19 11L20 16H18L19 11M5 7L6 10H4L5 7M19 7L20 10H18L19 7Z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xl sm:text-2xl font-extrabold tracking-tight text-slate-900 group-hover:text-emerald-700 transition-colors">
                            O'sh Namoz
                        </span>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200">
                            Masjidlar
                        </span>
                    </div>
                    <p class="text-xs text-slate-500 font-medium">Jamoat vaqtlari & interaktiv xarita • .vexa.uz</p>
                </div>
            </a>

            <!-- Navigation Links -->
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#karta" class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 transition-all border border-slate-200">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Xarita
                </a>

                @auth
                    @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('superadmin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-slate-900 hover:bg-slate-800 shadow-sm transition-all">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Superadmin
                        </a>
                    @else
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-emerald-700 hover:bg-emerald-800 shadow-sm shadow-emerald-800/30 transition-all">
                            <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            Kabinet
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" title="Chiqish" class="p-2.5 rounded-xl text-slate-500 hover:text-red-600 hover:bg-red-50 border border-slate-200 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-bold text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 shadow-xs transition-all">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        Masjid Admini
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-medium text-sm">{{ session('success') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-medium text-sm">{{ session('error') }}</span>
                    </div>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-14 pb-10 border-t border-slate-800 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 pb-10 border-b border-slate-800">
                <!-- Col 1: About -->
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-amber-300">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C11.5 2 11 2.4 11 3C11 3.2 11.1 3.4 11.2 3.6C10.5 4.3 10 5.4 10 6.6C10 7.8 10.6 8.9 11.5 9.6C9.5 10.5 8 12.6 8 15V21H16V15C16 12.6 14.5 10.5 12.5 9.6C13.4 8.9 14 7.8 14 6.6C14 5.4 13.5 4.3 12.8 3.6C12.9 3.4 13 3.2 13 3C13 2.4 12.5 2 12 2Z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white tracking-tight">O'sh Namoz Portali</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Qirg'izistonning O'sh viloyati va O'sh shahri masjidlari uchun yagona jamoat namozi vaqtlari va interaktiv xarita tizimi. Har bir masjid mas'uli namoz vaqtlarini mustaqil boshqaradi.
                    </p>
                </div>

                <!-- Col 2: Quran verse -->
                <div class="bg-slate-850/60 rounded-2xl p-6 border border-slate-800">
                    <span class="text-amber-400 text-xs font-semibold uppercase tracking-wider block mb-2">Qur'oni Karim</span>
                    <p class="text-lg font-quran text-emerald-200 leading-loose text-right mb-2" dir="rtl">
                        إِنَّ الصَّلَاةَ كَانَتْ عَلَى الْمُؤْمِنِينَ كِتَابًا مَّوْقُوتًا
                    </p>
                    <p class="text-xs text-slate-400 italic">
                        "Albatta, namoz mo'minlarga vaqtida tayinlangan farzdir."
                        <span class="block text-slate-500 font-normal mt-1">(Niso surasi, 103-oyat)</span>
                    </p>
                </div>

                <!-- Col 3: Contacts & Regions -->
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-200 mb-3">Qamrab olingan hududlar</h3>
                    <div class="flex flex-wrap gap-1.5 text-xs text-slate-400">
                        <span class="bg-slate-800 px-2.5 py-1 rounded-lg">O'sh shahri</span>
                        <span class="bg-slate-800 px-2.5 py-1 rounded-lg">Qorasuv</span>
                        <span class="bg-slate-800 px-2.5 py-1 rounded-lg">Novqat</span>
                        <span class="bg-slate-800 px-2.5 py-1 rounded-lg">O'zgan</span>
                        <span class="bg-slate-800 px-2.5 py-1 rounded-lg">Aravon</span>
                        <span class="bg-slate-800 px-2.5 py-1 rounded-lg">Oloy</span>
                        <span class="bg-slate-800 px-2.5 py-1 rounded-lg">Qoraqulja</span>
                        <span class="bg-slate-800 px-2.5 py-1 rounded-lg">Chon-Oloy</span>
                    </div>
                    <div class="mt-4 pt-3 border-t border-slate-800 text-xs text-slate-500">
                        Loyihaviy platforma: <span class="text-emerald-400 font-semibold">masjid.vexa.uz</span>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} O'sh Namoz Portali. Barcha huquqlar himoyalangan.</p>
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="hover:text-emerald-400 transition-colors">Bosh sahifa</a>
                    <a href="{{ route('login') }}" class="hover:text-emerald-400 transition-colors">Masjid Admini</a>
                    <a href="https://vexa.uz" target="_blank" class="hover:text-emerald-400 transition-colors">Vexa.uz</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Real-time Osh Clock JS -->
    <script>
        function updateOshClock() {
            const now = new Date();
            // Osh is UTC+6
            const utc = now.getTime() + (now.getTimezoneOffset() * 60000);
            const oshTime = new Date(utc + (3600000 * 6));
            
            const hours = String(oshTime.getHours()).padStart(2, '0');
            const minutes = String(oshTime.getMinutes()).padStart(2, '0');
            const seconds = String(oshTime.getSeconds()).padStart(2, '0');
            
            const el = document.getElementById('currentTimeDisplay');
            if (el) {
                el.textContent = `${hours}:${minutes}:${seconds}`;
            }
        }
        setInterval(updateOshClock, 1000);
        updateOshClock();
    </script>

    @stack('scripts')
</body>
</html>
