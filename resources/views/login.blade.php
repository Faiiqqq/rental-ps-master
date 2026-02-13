<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental PS</title>
    @vite('resources/css/app.css')
    {{-- Tambahkan Font Inter agar lebih modern --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="min-h-screen flex items-center justify-center p-6">

        <div class="w-full max-w-sm">

            {{-- Logo / Judul App --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 text-white mb-4 shadow-lg shadow-blue-200">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="6" width="20" height="12" rx="2"></rect><path d="M6 12h4"></path><path d="M14 12h4"></path><line x1="8" y1="12" x2="8" y2="12.01"></line><line x1="16" y1="12" x2="16" y2="12.01"></line></svg>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Rental PlayStation</h1>
                <p class="text-sm text-gray-500 mt-2">Masuk untuk mengelola rental & transaksi</p>
            </div>

            {{-- Card Login --}}
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                
                <div class="p-8">
                    {{-- Alert Error --}}
                    @if (session('error'))
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-r text-sm flex items-start gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 flex shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="/login" method="POST" class="space-y-5">
                        @csrf

                        {{-- Input Email --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                </div>
                                <input type="email" name="email" required placeholder="nama@email.com" autofocus
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition text-sm">
                            </div>
                        </div>

                        {{-- Input Password --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                                </div>
                                <input type="password" name="password" required placeholder="••••••••"
                                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition text-sm">
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg hover:shadow-blue-500/30 transition transform hover:-translate-y-0.5 active:scale-95 duration-200">
                            Masuk ke Dashboard
                        </button>

                    </form>
                </div>
            </div>
            
            {{-- Hint Login (Opsional, hapus saat production) --}}
            <p class="text-center text-xs text-gray-400 mt-8">
                Jika belum punya akun, hubungi Administrator.
            </p>

        </div>
    </div>
</body>
</html>