<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>RENTAL PS</title>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="min-h-screen flex items-center justify-center">

        <div class="w-full max-w-md">

            {{-- Card --}}
            <div class="bg-gray-50 border border-gray-200 rounded-2xl shadow-sm">

                {{-- Header --}}
                <div class="px-6 py-5 border-b border-gray-200 text-center">
                    <h2 class="text-xl font-semibold text-gray-800">
                        Login
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">
                        Silakan masuk ke akun Anda
                    </p>
                </div>

                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 text-red-700 rounded text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Form --}}
                <form action="/login" method="POST" class="px-6 py-6 space-y-5">
                    @csrf
                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama
                        </label>
                        <input type="text" name="nama" required placeholder="Masukan Nama anda"
                            class="w-full rounded text-sm p-2
                                bg-linear-to-b from-gray-50 to-gray-100
                                border border-gray-300
                                hover:border-gray-400">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Password
                        </label>
                        <input type="password" name="password" required placeholder="********"
                            class="w-full rounded text-sm p-2
                                bg-linear-to-b from-gray-50 to-gray-100
                                border border-gray-300
                                hover:border-gray-400">
                    </div>
                    {{-- Button --}}
                    <button type="submit"
                        class="w-full py-2.5 text-sm font-medium text-white
                        bg-blue-600 rounded-lg
                        hover:bg-blue-700 transition">
                        Login
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
