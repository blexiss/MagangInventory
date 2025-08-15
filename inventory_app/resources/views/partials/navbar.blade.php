<nav x-data="{ open: false }" class="relative bg-gray-950/50 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
  <div class="mx-auto px-4 sm:px-6 lg:px-6">
    <div class="relative flex h-16 items-center justify-between">

      <!-- Item Details Modal (Hidden) -->
      <div id="itemModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-gray-900 rounded-lg w-full max-w-lg p-6 relative">
          <button id="closeModal" class="absolute top-3 right-3 text-white text-lg font-bold">&times;</button>
          <div id="modalContent"></div>
        </div>
      </div>

      <!-- Hamburger for Mobile -->
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <button @click="open = true" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
          <span class="sr-only">Open main menu</span>
          <!-- Hamburger open icon -->
          <svg :class="{'hidden': open, 'block': !open }" class="block h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <!-- Hamburger close icon -->
          <svg :class="{'hidden': !open, 'block': open }" class="hidden h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Logo + Desktop Navbar Buttons -->
      <div class="flex flex-1 items-center sm:items-stretch sm:justify-start space-x-6 pl-12 sm:pl-0">
        <div class="flex shrink-0 items-center">
          <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="h-8 w-auto" />
        </div>
        <div class="hidden sm:flex space-x-4">
          <a href="{{ route('dashboard') }}" 
             @if($currentPage === 'dashboard') aria-current="page" @endif
             class="rounded-md px-3 py-2 text-sm font-medium {{ $currentPage === 'dashboard' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} whitespace-nowrap">
             Dashboard
          </a>

          <a href="{{ route('inventory') }}" 
             @if($currentPage === 'inventory') aria-current="page" @endif
             class="rounded-md px-3 py-2 text-sm font-medium {{ $currentPage === 'inventory' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} whitespace-nowrap">
             Inventory
          </a>

          <a href="{{ route('audit-logs') }}" 
             @if($currentPage === 'audit-logs') aria-current="page" @endif
             class="rounded-md px-3 py-2 text-sm font-medium {{ $currentPage === 'audit-logs' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} whitespace-nowrap">
             Audit Logs
          </a>
        </div>
      </div>

      <!-- Search Bar -->
      <div class="relative ml-auto max-w-xs min-w-[100px] sm:min-w-[150px]">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input type="text" id="search_bar" class="block w-full rounded-lg border border-gray-300 bg-transparent px-10 pt-2 pb-2 text-sm text-gray-900 appearance-none dark:border-gray-600 dark:bg-gray-900 dark:text-white focus:border-blue-600 focus:outline-none focus:ring-0 peer" placeholder=" " />
        <label for="search_bar" class="absolute top-2 z-10 origin-[0] px-2 text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75
          peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
          peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75 dark:text-gray-400 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 start-1 bg-white dark:bg-gray-900">
          Search ID or Items
        </label>
      </div>
    </div>

    <!-- Mobile Off-canvas Sidebar -->
<div x-show="open" class="fixed inset-0 z-50 flex">
  <!-- Overlay with blur -->
  <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="open = false"></div>


  <!-- Sidebar content -->
  <div class="relative bg-gray-900 w-64 h-full p-4">
    <ul class="mt-8 space-y-2">
      <li> 
        <a href="{{ route('dashboard') }}" 
           @if($currentPage === 'dashboard') aria-current="page" @endif
           class="{{ $currentPage === 'dashboard' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} block px-3 py-2 rounded">
           Dashboard
        </a>
      </li>
      <li>
        <a href="{{ route('inventory') }}" 
           @if($currentPage === 'inventory') aria-current="page" @endif
           class="{{ $currentPage === 'inventory' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} block px-3 py-2 rounded">
           Inventory
        </a>
      </li>
      <li>
        <a href="{{ route('audit-logs') }}" 
           @if($currentPage === 'audit-logs') aria-current="page" @endif
           class="{{ $currentPage === 'audit-logs' ? 'bg-gray-950/50 text-white' : 'text-gray-300 hover:bg-white/5 hover:text-white' }} block px-3 py-2 rounded">
           Audit Logs
        </a>
      </li>
    </ul>
  </div>
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
