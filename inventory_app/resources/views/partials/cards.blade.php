<div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6">

        <!-- Kartu Printing-->
        <a href="{{ route('inventory') }}?category=Printing"
            class="flex flex-col md:flex-row bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <img class="object-cover rounded-t-lg md:rounded-l-lg md:rounded-t-none w-full md:w-1/3 h-full p-4 "
                src="{{ asset('images/Printing.png') }}" alt="Printing">
            <div class="flex flex-col justify-center p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Printing</h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Printer, Kertas, dan Cartridge</p>
            </div>
        </a>

        <!-- Kartu Monitoring -->
        <a href="{{ route('inventory') }}?category=Monitoring"
            class="flex flex-col md:flex-row bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <img class="object-cover rounded-t-lg md:rounded-l-lg md:rounded-t-none w-full md:w-1/3 h-full p-4"
                src="{{ asset('images/Monitoring.png') }}" alt="Printing">
            <div class="flex flex-col justify-center p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Monitoring</h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">CCTV dan Coaxial </p>
            </div>
        </a>

        <!-- Kartu Workstation -->
        <a href="{{ route('inventory') }}?category=Workstation"
            class="flex flex-col md:flex-row bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <img class="object-cover rounded-t-lg md:rounded-l-lg md:rounded-t-none w-full md:w-1/3 h-full p-4"
                src="{{ asset('images/Workstation.png') }}" alt="Printing">
            <div class="flex flex-col justify-center p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Workstation</h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Monitor, Keyboard, Mouse, dan PC</p>
            </div>
        </a>

        <!-- Kartu Networking -->
        <a href="{{ route('inventory') }}?category=Networking"
            class="flex flex-col md:flex-row bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
            <img class="object-cover rounded-t-lg md:rounded-l-lg md:rounded-t-none w-full md:w-1/3 h-full p-4"
                src="{{ asset('images/Networking.png') }}" alt="Printing">
            <div class="flex flex-col justify-center p-4 leading-normal">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Networking</h5>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Router, Switch, dan LAN</p>
            </div>
        </a>



    </div>