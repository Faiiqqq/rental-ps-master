<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rental PS')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 font-sans">

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar --}}
        @include('layout.sidebar')

        <div class="flex flex-col flex-1">

            {{-- Navbar --}}
            @include('layout.navbar')

            {{-- Content --}}
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>

        </div>
    </div>

</body>

</html>
