<aside class="w-64 bg-gray-50 border-r border-gray-200 hidden md:flex flex-col">
    {{-- Logo --}}
    <div class="h-16 flex items-center px-6 border-b border-gray-200">
        <span class="text-sm font-bold">
            FAIQ RENTAL
        </span>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 px-4 py-6 space-y-1 text-sm">

        <a href="/"
            class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
            Dashboard
        </a>
        <a href="/user"
            class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
            Users
        </a>
        <a href="/pelanggan"
            class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
            Pelanggan
        </a>
        <a href="/playstation"
            class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
            Playstation
        </a>
        <a href="/transaksi"
            class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
            Transaksi
        </a>
        <a href="/laporan"
            class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
            Laporan
        </a>
        <a href="/log-activity"
            class="flex items-center px-4 py-2 rounded-lg
                text-gray-700 hover:bg-gray-200 transition">
            Log Activity
        </a>
    </nav>

    {{-- Logout --}}
    <div class="px-4 py-4 border-t border-gray-200">
        <form action="/logout" method="POST">
            @csrf
            <button class="flex w-full px-4 py-2 text-red-500 hover:bg-red-50 rounded-lg">
                Logout
            </button>
        </form>
    </div>
</aside>
