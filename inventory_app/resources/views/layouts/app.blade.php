<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="bg-white dark:bg-gray-800 m-0 p-0">

    @include('partials.navbar')

    <main class="">
        @yield('content')
    </main>

    <script src="{{ asset('path/to/flowbite/dist/flowbite.min.js') }}"></script>
</body>
</html>
