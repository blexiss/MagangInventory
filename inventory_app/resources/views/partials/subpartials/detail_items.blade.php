<!DOCTYPE html>
<html lang="en" class="scroll-smooth h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-white dark:bg-gray-800 m-0 p-0 h-full" x-data="useItemHandler()">

    <div class="flex flex-col md:flex-row h-screen">
        <!-- Left Panel -->
        <div class="w-full md:w-1/4 p-6 border-b md:border-r md:border-b-0 border-gray-300 dark:border-gray-700 flex flex-col items-center">
            @php
            $total = $item->quantity > 0 ? $item->quantity : 1;
            $used = ($item->use / $total) * 100;
            $damaged = ($item->damaged / $total) * 100;
            $available = $total - $item->use - $item->damaged;
            @endphp

            <div class="flex flex-col items-center">
                <!-- Progress Circle -->
                <div class="relative w-32 h-32 flex items-center justify-center mb-4">
                    <svg class="absolute w-full h-full" viewBox="0 0 36 36">
                        <path class="text-gray-300" stroke-width="4" fill="none" stroke="currentColor"
                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        @if($available>0)
                        <path class="text-blue-400" stroke-width="4" fill="none" stroke="currentColor"
                            stroke-dasharray="{{$total}}, 100" stroke-linecap="round"
                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        @endif
                        @if($item->use>0)
                        <path class="text-yellow-400" stroke-width="4" fill="none" stroke="currentColor"
                            stroke-dasharray="{{ $used + $damaged }}, 100" stroke-linecap="round"
                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        @endif
                        @if($item->damaged>0)
                        <path class="text-red-400" stroke-width="4" fill="none" stroke="currentColor"
                            stroke-dasharray="{{ $damaged }}, 100" stroke-linecap="round"
                            d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                        @endif
                    </svg>

                    <div class="text-3xl font-bold text-gray-800 dark:text-white">
                        {{ $item->quantity }}
                    </div>
                </div>

                <!-- Legend -->
                <div class="flex gap-2 text-sm text-gray-700 dark:text-gray-200 mb-10">
                    <div class="flex items-center gap-2 mr-4">
                        <span class="w-3 h-3 bg-blue-400 rounded-full"></span>
                        <span>Available: {{ $available }}</span>
                    </div>
                    <div class="flex items-center gap-2 mr-4">
                        <span class="w-3 h-3 bg-yellow-400 rounded-full"></span>
                        <span>Used: {{ $item->use }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-red-400 rounded-full"></span>
                        <span>Damaged: {{ $item->damaged }}</span>
                    </div>
                </div>
            </div>

            <!-- Quantity Controls -->
            <form action="{{ route('inventory.updateQuantity', $item->id) }}" method="POST"
                class="flex flex-col md:flex-row gap-2 mb-4 w-full md:w-auto">
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
            <button type="button" @click="openUseItemModal()"
                class="w-full px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                Use Items
            </button>

            <!-- Back Button -->
            <a href="{{ route('inventory') }}"
                class="mt-4 w-full px-4 py-2 text-center text-white bg-gray-600 rounded hover:bg-gray-700">
                Back To Inventory
            </a>
        </div>

        <!-- Right Panel -->
        <div class="flex-1 p-6 overflow-y-auto" x-data="jsonTableHandler()">
            <form id="deleteForm" action="{{ route('items.updateJson', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="flex flex-col md:flex-row items-center justify-between mb-4 gap-2">
                    <div class="flex flex-1 max-w-xs mt-2 mb-2 sm:mt-0 sm:mb-0">
                        <div class="relative w-full sm:max-w-xs sm:min-w-[150px]">
                            <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" name="search" x-model="searchQuery" @input="filterTable()"
                                class="block w-full px-10 pt-2 pb-2 text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-blue-600 focus:outline-none focus:ring-0"
                                placeholder="Search ID or Items..." />
                        </div>
                    </div>
                    <div class="flex gap-2 md:mt-0" x-show="hasSelected">
                        <!-- Tombol trigger modal alasan -->
                        <button type="button" @click="openReasonModal('return')"
                            class="px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-700">Return</button>
                        <button type="button" @click="openReasonModal('damaged')"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Damaged</button>
                    </div>
                </div>

                <!-- Table -->
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-2"><input type="checkbox" @click="toggleAll($event)" /></th>
                            <th class="px-6 py-2">No</th>
                            <th class="px-6 py-2">Used At</th>
                            @if(!empty($item->json))
                            @foreach(array_keys($item->json[0]) as $field)
                            @if($field !== 'used_at')
                            <th class="px-6 py-2">{{ ucwords(str_replace('_',' ',$field)) }}</th>
                            @endif
                            @endforeach
                            @endif
                            <th class="px-6 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($item->json as $index => $entry)
                        <tr class="{{ $index % 2 == 0 ? 'bg-gray-50 dark:bg-gray-700' : '' }}">
                            <td class="px-6">
                                <input type="checkbox" name="delete[{{ $index }}]" value="1" x-model="selected[{{ $index }}]" />
                            </td>
                            <td class="px-6 py-2">{{ $index + 1 }}</td>
                            <td class="px-6 py-2">{{ $entry['used_at'] ?? '-' }}</td>

                            @foreach($entry as $key => $value)
                            @if($key !== 'used_at')
                            <td class="px-6 py-2">
                                {{ is_array($value) ? json_encode($value) : $value }}
                            </td>
                            @endif
                            @endforeach

                            <td class="px-6 py-2">
                                <button type="button" @click="openModal({{ $index }})" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="100%" class="px-6 py-3 text-center text-gray-400">No data used yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>

            <!-- Modal Update -->
            <div x-show="isModalOpen" x-transition class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-full max-w-md">
                    <h2 class="text-xl font-bold mb-4">Update Entry</h2>
                    <form action="{{ route('items.updateJson', $item->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="update">

                        <template x-for="(value, key) in modalEntry" :key="key">
                            <label class="block">
                                <span x-text="key"></span>:
                                <input type="text"
                                    :name="'json['+modalIndex+']['+key+']'"
                                    x-model="modalEntry[key]"
                                    :readonly="key==='used_at'"
                                    class="border rounded p-2 w-full dark:bg-gray-700 dark:text-white" />
                            </label>
                        </template>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Save</button>
                            <button type="button" @click="isModalOpen=false" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Use Items -->
            <div x-show="isOpen" x-transition class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-full max-w-md">
                    <h2 class="text-xl font-bold mb-4">Use Item: {{ $item->name }}</h2>

                    <form action="{{ route('items.use.process', $item->id) }}" method="POST" class="space-y-4">
                        @csrf

                        <label class="block">
                            Location:
                            <input type="text" name="location" class="border rounded p-2 w-full dark:bg-gray-700 dark:text-white">
                        </label>

                        <template x-for="field in fields" :key="field">
                            <label class="block">
                                <span x-text="field"></span>:
                                <input type="text" :name="field.toLowerCase().replace(/ /g,'_')" class="border rounded p-2 w-full dark:bg-gray-700 dark:text-white">
                            </label>
                        </template>

                        <div class="flex justify-end gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Use</button>
                            <button type="button" @click="isOpen = false" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Reason -->
            <div x-show="isReasonOpen" x-transition class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                <div class="bg-white dark:bg-gray-800 p-6 rounded shadow-lg w-full max-w-md">
                    <h2 class="text-xl font-bold mb-4" x-text="'Reason for ' + reasonAction"></h2>
                    <form @submit.prevent="submitWithReason()" class="space-y-4">
                        <input type="hidden" name="action" x-model="reasonAction">
                        <label class="block">
                            Reason:
                            <textarea name="reason" x-model="reasonText" required
                                class="border rounded p-2 w-full dark:bg-gray-700 dark:text-white"></textarea>
                        </label>
                        <div class="flex justify-end gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Submit</button>
                            <button type="button" @click="isReasonOpen=false" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        function useItemHandler() {
            return {
                isOpen: false,
                fields: [],
                openUseItemModal() {
                    const fieldsByCategory = {
                        'Printer': ['Connectivity (USB/WiFi)'],
                        'Paper': ['Size'],
                        'Cartridge': ['Color'],
                        'CCTV': ['Camera Type', 'Resolution', 'IP Address', 'Stream URL'],
                        'Coaxial': ['Length (Meter)'],
                        'Router': ['IP Address', 'WiFi Standard'],
                        'Switch': ['# of Ports', 'IP Address'],
                        'AP': ['SSID', 'IP Address', 'Max User'],
                        'Monitor': ['Screen Size', 'Resolution'],
                        'PC': ['CPU', 'RAM', 'HDD/SSD Size'],
                        'Mouse': ['Connectivity'],
                    };
                    const category = "{{ $item->subcategory->name ?? 'Unknown' }}";
                    this.fields = fieldsByCategory[category] || [];
                    this.isOpen = true;
                }
            }
        }

        function jsonTableHandler() {
            return {
                jsonData: @json($item->json),
                selected: {},
                isModalOpen: false,
                modalEntry: {},
                modalIndex: null,
                searchQuery: '',
                isReasonOpen: false,
                reasonText: '',
                reasonAction: '',
                get hasSelected() {
                    return Object.values(this.selected).some(v => v);
                },
                openModal(index) {
                    this.modalIndex = index;
                    this.modalEntry = {...this.jsonData[index]};
                    this.isModalOpen = true;
                },
                openReasonModal(action) {
                    this.reasonAction = action;
                    this.reasonText = '';
                    this.isReasonOpen = true;
                },
                submitWithReason() {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("items.updateJson", $item->id) }}';
                    form.innerHTML = `
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="action" value="${this.reasonAction}">
                        <input type="hidden" name="reason" value="${this.reasonText}">
                    `;
                    Object.entries(this.selected).forEach(([idx, val]) => {
                        if(val) {
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'delete['+idx+']';
                            input.value = '1';
                            form.appendChild(input);
                        }
                    });
                    document.body.appendChild(form);
                    form.submit();
                },
                toggleAll(event) {
                    const checked = event.target.checked;
                    this.jsonData.forEach((_, idx) => {
                        this.selected[idx] = checked;
                    });
                },
                filterTable() {
                    const query = this.searchQuery.toLowerCase();
                    const tbody = document.querySelector('tbody');
                    tbody.querySelectorAll('tr').forEach((row, idx) => {
                        if (this.jsonData[idx]) {
                            const values = Object.values(this.jsonData[idx]).map(v => String(v).toLowerCase());
                            row.style.display = values.some(v => v.includes(query)) ? '' : 'none';
                        }
                    });
                }
            }
        }
    </script>

</body>
</html>
