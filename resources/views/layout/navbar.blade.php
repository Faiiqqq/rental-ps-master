<nav class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center justify-between">
    <h1 class="text-lg font-semibold text-gray-800 tracking-tight">
        @yield('page-title', 'Dashboard')
    </h1>

    <div class="flex items-center gap-3 text-sm text-gray-600">
        <span class="text-lg font-bold text-blue-600">
            {{ ucfirst(auth()->user()->role) }}
        </span>
    </div>
</nav>
