<!DOCTYPE html>
<html lang="en" class="scroll-smooth h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white dark:bg-gray-800 m-0 p-0 h-full">

    <!-- Wrapper -->
    <div class="flex flex-col md:flex-row h-screen">
        <!-- Left Panel -->
        <div class="w-full md:w-1/4 p-6 border-b md:border-r md:border-b-0 border-gray-300 dark:border-gray-700 flex flex-col items-center">

            <!-- Circle Quantity -->
            <div class="w-32 h-32 rounded-full border-4 border-gray-500 flex items-center justify-center text-3xl font-bold text-gray-800 dark:text-white mb-6">
                {{ $item->quantity }}
            </div>

            <!-- Quantity Controls -->
            <form action="{{ route('inventory.updateQuantity', $item->id) }}" method="POST" class="flex flex-col md:flex-row gap-2 mb-4 w-full md:w-auto">
                @csrf
                @method('PUT')

                <input type="number" name="amount" value="1"
                    class="w-full md:w-40 text-center border rounded dark:bg-gray-800 dark:border-gray-600 dark:text-white" />

                <div class="flex gap-2 mt-2 md:mt-0">
                    <button name="action" value="out"
                        class="dark:text-white px-3 py-2 border rounded bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 w-full md:w-auto">
                        OUT
                    </button>
                    <button name="action" value="in"
                        class="dark:text-white px-3 py-2 border rounded bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 w-full md:w-auto">
                        IN
                    </button>
                </div>
            </form>

            <!-- Use Items Button -->
            <button type="button" id="addItemBtn"
                class="w-full px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                Use Items
            </button>

            <!-- buttton back -->
            <a href="{{ route('inventory') }}"
                class="mt-4 w-full px-4 py-2 text-center text-white bg-gray-600 rounded hover:bg-gray-700">
                Back To Inventory
            </a>
        </div>

        <!-- Right Panel -->
        <div class="flex-1 p-6 overflow-y-auto">
            <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                <thead
                    class="text-xs text-gray-700 uppercase rounded-t-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Name</th>
                        <th class="px-6 py-3">Quantity</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-6 py-3">1</td>
                        <td class="px-6 py-3">Item Name</td>
                        <td class="px-6 py-3">20</td>
                        <td class="px-6 py-3">Category A</td>
                        <td class="px-6 py-3">Action</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>