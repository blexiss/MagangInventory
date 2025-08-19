<nav x-data="{ open: false }"
    class="relative bg-gray-950/50 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
    <div class="mx-auto px-4 sm:px-6 lg:px-6">
        <div class="relative flex h-16 items-center justify-between">

            <!-- Hamburger for Mobile -->
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button @click="open = true" type="button"
                    class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <!-- Hamburger open icon -->
                    <svg :class="{ 'hidden': open, 'block': !open }" class="block h-6 w-6" fill="none"
                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                    <!-- Hamburger close icon -->
                    <svg :class="{ 'hidden': !open, 'block': open }" class="hidden h-6 w-6" fill="none"
                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Logo + Desktop Navbar Buttons -->
            <div class="flex flex-1 items-center sm:items-stretch sm:justify-start space-x-6 pl-12 sm:pl-0">
                <div class="flex shrink-0 items-center">
                    <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500"
                        alt="Your Company" class="h-8 w-auto" />
                </div>
                @php
                    $navLinks = [
                        ['title' => 'Dashboard', 'route' => 'dashboard'],
                        ['title' => 'Inventory', 'route' => 'inventory'],
                        ['title' => 'Audit Logs', 'route' => 'audit-logs'],
                    ];
                @endphp

                <div class="hidden sm:flex space-x-4">
                    @foreach ($navLinks as $link)
                        <a href="{{ route($link['route']) }}"
                            @if ($currentPage === $link['route']) aria-current="page" @endif
                            class="rounded-md px-3 py-2 text-sm font-medium 
                  {{ $currentPage === $link['route'] ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} 
                  whitespace-nowrap">
                            {{ $link['title'] }}
                        </a>
                    @endforeach
                </div>

            </div>


        <!-- Mobile Off-canvas Sidebar -->
        <div x-show="open" class="fixed inset-0 z-50 flex">
            <!-- Overlay with blur -->
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>


            <!-- Sidebar content -->
            @php
                $sidebarLinks = [
                    ['name' => 'Dashboard', 'route' => 'dashboard'],
                    ['name' => 'Inventory', 'route' => 'inventory'],
                    ['name' => 'Audit Logs', 'route' => 'audit-logs'],
                ];
            @endphp

            <!-- Sidebar content -->
            <div class="relative bg-gray-900 w-64 h-full p-4">
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


            <script>
                const btn = document.getElementById('mobile-menu-button');
                const menu = document.getElementById('mobile-menu');
                const openIcon = btn.querySelector('svg.block');
                const closeIcon = btn.querySelector('svg.hidden');

                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                    openIcon.classList.toggle('hidden');
                    closeIcon.classList.toggle('hidden');
                });

                function handleResize() {
                    if (window.innerWidth >= 640) { // sm breakpoint
                        // Ensure sidebar is hidden on desktop
                        menu.classList.add('hidden');
                        openIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    }
                }

                // Run on load and on resize
                window.addEventListener('resize', handleResize);
                window.addEventListener('DOMContentLoaded', handleResize);
            </script>


</nav>
