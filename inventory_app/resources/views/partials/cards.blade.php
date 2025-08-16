@php
    $cards = [
        [
            'title' => 'Printing',
            'image' => 'Printing.png',
            'description' => 'Printer, Kertas, dan Cartridge',
            'category' => 'Printing',
        ],
        [
            'title' => 'Monitoring',
            'image' => 'Monitoring.png',
            'description' => 'CCTV dan Coaxial',
            'category' => 'Monitoring',
        ],
        [
            'title' => 'Networking',
            'image' => 'Networking.png',
            'description' => 'Router, Switch, AP, dan LAN',
            'category' => 'Networking',
        ],
        [
            'title' => 'Workstation',
            'image' => 'Workstation.png',
            'description' => 'Monitor, Keyboard, Mouse, dan PC',
            'category' => 'Workstation',
        ],
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">
    @foreach ($cards as $card)
        <a href="{{ route('inventory') }}?category={{ $card['category'] }}"
            class="flex flex-col md:flex-row bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <img class="object-cover rounded-t-lg md:rounded-l-lg md:rounded-t-none w-full md:w-1/3 h-full p-4"
                src="{{ asset('images/' . $card['image']) }}" alt="{{ $card['title'] }}">
            <div class="flex flex-col justify-center p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $card['title'] }}
                </h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $card['description'] }}</p>
            </div>
        </a>
    @endforeach
</div>
