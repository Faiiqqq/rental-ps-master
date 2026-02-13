<nav class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between shadow-sm sticky top-0 z-50">
    
    {{-- Judul Halaman Dinamis --}}
    <h1 class="text-xl font-bold text-gray-800 tracking-tight flex items-center gap-2">
        <i data-feather="grid" class="w-5 h-5 text-blue-600"></i>
        @yield('page-title', 'Dashboard')
    </h1>

    {{-- User Profile Section --}}
    <div class="flex items-center gap-4">
        
        {{-- Info User --}}
        <div class="text-right hidden md:block">
            <p class="text-sm font-bold text-gray-800 leading-none">{{ auth()->user()->nama }}</p>
            <p class="text-xs text-blue-600 font-medium uppercase mt-1">{{ auth()->user()->role }}</p>
        </div>

        {{-- Avatar Circle --}}
        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-lg shadow-md border-2 border-blue-100 uppercase">
            {{ substr(auth()->user()->nama, 0, 1) }}
        </div>

    </div>
</nav>