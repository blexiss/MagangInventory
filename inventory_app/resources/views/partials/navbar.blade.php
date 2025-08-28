<nav x-data="{ open: false }" class="relative bg-gray-950/50 {{ $currentPage !== 'inventory' ? 'hidden sm:block' : '' }}">
    <div class="px-4 mx-auto sm:px-6 lg:px-6">
        <div class="flex items-center justify-between h-16">
            @if ($currentPage === 'inventory')
            
        @endif        
            
            <!-- Desktop -->
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
</nav>

<!-- Mobile Bottom Navbar -->
<div class="fixed bottom-0 left-0 z-50 w-full bg-gray-900 border-t border-gray-700 sm:hidden">
  <div class="grid h-16 max-w-lg grid-cols-3 mx-auto">
    @php
      $bottomNav = [
        ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => 'M3 3h7v7H3V3z M14 3h7v7h-7V3z M3 14h7v7H3v-7z M14 14h7v7h-7v-7z'], 
        ['name' => 'Inventory', 'route' => 'inventory', 'icon' => 'M20 13V7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v6m16 0v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-6m16 0H4'],
        ['name' => 'Audit Logs', 'route' => 'audit-logs', 'icon' => 'M9 12h6m-6 4h6M9 8h6M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2z']
      ];
    @endphp

    @foreach ($bottomNav as $link)
      <a href="{{ route($link['route']) }}"
         class="inline-flex flex-col items-center justify-center px-5 
                {{ $currentPage === $link['route'] ? 'text-blue-500' : 'text-gray-400 hover:text-white' }}">
        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}" />
        </svg>
        <span class="text-xs">{{ $link['name'] }}</span>
      </a>
    @endforeach
  </div>
</div>