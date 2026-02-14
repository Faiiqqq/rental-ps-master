<aside class="w-64 bg-gray-50 border-r border-gray-200 hidden md:flex flex-col">
    {{-- Logo --}}
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <span class="text-xl font-bold text-blue-600">
            FAIQ RENTAL
        </span>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 px-4 py-6 space-y-1 text-sm">

        {{-- DASHBOARD (Semua Bisa Akses) --}}
        <a href="/"
            class="flex items-center px-4 py-2 rounded-lg transition
            {{ request()->is('/') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-200' }}">
            <i class="mr-3" data-feather="home"></i>
            Dashboard
        </a>

        {{-- TRANSAKSI (Semua Bisa Akses) --}}
        <a href="{{ route('transaksi.index') }}"
            class="flex items-center px-4 py-2 rounded-lg transition
            {{ request()->is('transaksi*') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-200' }}">
            <i class="mr-3" data-feather="shopping-cart"></i>
            Transaksi
        </a>

        {{-- PLAYSTATION (Semua Bisa Akses) --}}
        <a href="{{ route('playstation.index') }}"
            class="flex items-center px-4 py-2 rounded-lg transition
            {{ request()->is('playstation*') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-200' }}">
            <i class="mr-3" data-feather="monitor"></i>
            Playstation
        </a>

        {{-- MENU KHUSUS ADMIN --}}
        @if(auth()->user()->role !== 'pelanggan')
            
            <div class="pt-4 pb-2 px-4 text-xs font-semibold text-gray-400 uppercase">
                Administrator
            </div>

            <a href="{{ route('user.index') }}"
                class="flex items-center px-4 py-2 rounded-lg transition
                {{ request()->is('user*') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-200' }}">
                <i class="mr-3" data-feather="users"></i>
                Users
            </a>

            {{-- Jika Anda punya route pelanggan terpisah, aktifkan ini --}}
            {{-- <a href="/pelanggan" class="...">Pelanggan</a> --}}

            <a href="{{ route('laporan.index') }}"
                class="flex items-center px-4 py-2 rounded-lg transition
                {{ request()->is('laporan*') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-200' }}">
                <i class="mr-3" data-feather="file-text"></i>
                Laporan
            </a>

            <a href="{{ route('log.index') }}"
                class="flex items-center px-4 py-2 rounded-lg transition
                {{ request()->is('log-activity*') ? 'bg-blue-100 text-blue-700 font-medium' : 'text-gray-700 hover:bg-gray-200' }}">
                <i class="mr-3" data-feather="activity"></i>
                Log Activity
            </a>
        @endif

    </nav>

    {{-- Logout --}}
    <div class="px-4 py-4 border-t border-gray-200">
        <form action="/logout" method="POST">
            @csrf
            <button class="flex w-full px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg transition items-center">
                <i class="mr-3" data-feather="log-out"></i>
                Logout
            </button>
        </form>
    </div>
</aside>