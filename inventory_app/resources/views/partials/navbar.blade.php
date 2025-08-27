<nav x-data="{ open: false }" class="relative bg-gray-950/50">
    <div class="px-4 mx-auto sm:px-6 lg:px-6">
        <div class="flex items-center justify-between h-16">

            <!-- Mobile Hamburger + Search -->
            <div class="flex items-center w-full space-x-2 sm:hidden">
                <!-- Hamburger -->
                <button @click="open = true" type="button"
                        class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:bg-white/5 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <svg :class="{ 'hidden': open, 'block': !open }" class="block w-6 h-6" fill="none"
                         stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                    <svg :class="{ 'hidden': !open, 'block': open }" class="hidden w-6 h-6" fill="none"
                         stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            
                <!-- Mobile Search -->
                <div class="flex-1 min-w-0">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="search_bar"
                               class="block w-full px-10 pt-2 pb-2 text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-blue-600 focus:outline-none focus:ring-0 peer"
                               placeholder=" " />
                        <label for="search_bar"
                               class="absolute top-2 z-10 origin-[0] px-2 text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75
                      peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
                      peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 dark:text-gray-400 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 start-1 bg-white dark:bg-gray-800">
                            Search ID or Items
                        </label>
                    </div>
                </div>
            </div>
            

            <!-- Desktop logo + links -->
            <div class="items-center flex-1 hidden space-x-6 sm:flex sm:items-stretch sm:justify-start">
                <div class="flex items-center shrink-0">
                    <img src="{{ asset('images/supply1.png') }}" alt="Your Company" class="w-auto h-8"/>
                </div>

                @php
                    $navLinks = [
                        ['title' => 'Dashboard', 'route' => 'dashboard'],
                        ['title' => 'Inventory', 'route' => 'inventory'],
                        ['title' => 'Audit Logs', 'route' => 'audit-logs'],
                    ];
                @endphp

                <div class="hidden space-x-4 sm:flex">
                    @foreach ($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                           @if ($currentPage === $link['route']) aria-current="page" @endif
                           class="rounded-md px-3 py-2 text-sm font-medium 
                          {{ $currentPage === $link['route'] ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                            {{ $link['title'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Off-canvas Sidebar -->
    <div x-show="open" x-transition class="fixed inset-0 z-50 flex">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>

        <!-- Sidebar -->
        <div class="relative w-64 h-full p-4 transition-transform duration-300 transform bg-gray-900"
             :class="{ 'translate-x-0': open, '-translate-x-full': !open }">
            <button @click="open = false" class="absolute text-gray-400 top-3 right-3 hover:text-white">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            @php
                $sidebarLinks = [
                    ['name' => 'Dashboard', 'route' => 'dashboard'],
                    ['name' => 'Inventory', 'route' => 'inventory'],
                    ['name' => 'Audit Logs', 'route' => 'audit-logs'],
                ];
            @endphp

            <ul class="mt-8 space-y-2">
                @foreach ($sidebarLinks as $link)
                    <li>
                        <a href="{{ route($link['route']) }}"
                           @if ($currentPage === strtolower($link['name'])) aria-current="page" @endif
                           class="{{ $currentPage === strtolower($link['name']) ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} block px-3 py-2 rounded">
                            {{ $link['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
