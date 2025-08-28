<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>



<body class="
    bg-white dark:bg-gray-800 
    {{ $currentPage === 'audit-logs' ? 'p-0 sm-p0 pb-4' : '' }}
    {{ $currentPage === 'inventory' ? 'p-0 sm:p-0' : '' }}
    {{ $currentPage === 'dashboard' ? 'p-0 sm:p-0 pb-16' : '' }}
">

    @include('partials.navbar')

    <main class="">
        @yield('content')
    </main>

    <script src="{{ asset('path/to/flowbite/dist/flowbite.min.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('scripts')
</body>

</html>
