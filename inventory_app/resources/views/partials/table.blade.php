    @extends('layouts.app')

    @section('content')
    <div class="flex items-center justify-between w-full gap-4">
        <!-- Add Items Button -->
        <button type="button" id="addItemBtn"
            class="block rounded-full border border-gray-300 bg-transparent text-gray-900 
               dark:border-gray-600 dark:bg-gray-800 dark:text-white
               w-12 h-12 text-2xl flex items-center justify-center
               fixed bottom-20 right-6 z-50                         
               sm:static sm:w-auto sm:h-auto sm:px-5 sm:py-2.5 sm:text-sm sm:rounded-lg sm:flex sm:items-center sm:justify-center sm:z-auto">
            <span class="sm:hidden">+</span>
            <span class="hidden sm:inline">Add Item</span>
        </button>

        <!-- Searchbar -->
        <div class="flex-1 flex mb-2 mt-2">
            <div class="relative w-full sm:max-w-xs sm:min-w-[150px]">
                <div class="absolute inset-y-0 flex items-center pointer-events-none start-0 ps-3">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="search_bar"
                    class="block w-full px-10 pt-2 pb-2 text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg appearance-none dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-blue-600 focus:outline-none focus:ring-0"
                    placeholder="Search ID or Items..." />
            </div>
        </div>

    </div>


    <!-- Table -->
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase rounded-t-lg bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Item Name</th>
                    <th class="px-6 py-3">Quantity</th>
                    <th class="px-6 py-3">Category</th>
                    <th class="px-6 py-3">Stock</th>
                    <th class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th class="px-6 py-4" scope="row">{{ $loop->iteration }}</th>
                    <td class="px-6 py-4">
                        <a href="{{ route('inventory.detailitems', ['id' => $item['id']]) }}"
                            class="font-bold text-black-600 hover:underline">
                            {{ $item['name'] }}
                        </a>
                    </td>
                    <td class="px-6 py-4">{{ $item['quantity'] }}</td>
                    <td class="px-6 py-4">
                        <span
                            class="text-xs font-medium px-2 py-0.5 rounded
                            @if ($item['category'] === 'Printing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
                            @elseif($item['category'] === 'Monitoring') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300
                            @elseif($item['category'] === 'Networking') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                            @elseif($item['category'] === 'Workstation') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                            @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300 @endif">
                            {{ $item['subcategory'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span
                            class="rounded-full border px-2.5 py-0.5 text-sm
                            @if ($item['status'] === 'Out of Stock') border-red-500 text-red-700 dark:text-red-300 whitespace-nowrap
                            @elseif($item['status'] === 'Low') border-yellow-500 text-yellow-700 dark:text-yellow-300 whitespace-nowrap
                            @elseif($item['status'] === 'In Stock') border-green-500 text-green-700 dark:text-green-300 whitespace-nowrap @endif">
                            {{ $item['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <!-- Tombol Edit -->
                        <button type="button"
                            class="mr-2 font-medium text-blue-600 editBtn dark:text-blue-500 hover:underline"
                            data-id="{{ $item['id'] }}" data-name="{{ $item['name'] }}"
                            data-subcategory-id="{{ $item['subcategory_id'] }}">
                            Edit
                        </button>

                        <!-- Tombol Delete -->
                        <form action="{{ route('inventory.destroy', $item['id']) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="font-medium text-red-600 deleteBtn dark:text-red-500 hover:underline">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        No products available
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="popup-modal" tabindex="-1"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/40 backdrop-blur-sm">
        <div class="relative w-full max-w-md p-4">
            <div class="relative bg-white rounded-lg shadow-lg dark:bg-gray-700">
                <button type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    id="closeDeleteModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                        Confirm Deletion?
                    </h3>
                    <button id="confirmDeleteBtn"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes
                    </button>
                    <button id="cancelDeleteBtn"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        No
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Add/Edit Item -->
    <div id="crud-modal"
        class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/40 backdrop-blur-sm">
        <div class="w-full max-w-md p-5 bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <div class="flex items-center justify-between pb-2 border-b dark:border-gray-600">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">Add New Item</h3>
                <button type="button" id="closeModal"
                    class="text-gray-400 hover:text-gray-900 dark:hover:text-white">✕</button>
            </div>

            <form id="crudForm" action="{{ route('inventory.store') }}" method="POST" class="grid gap-4 mt-4">
                @csrf
                <div>
                    <label for="name"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                    <input type="text" name="name" id="name"
                        class="bg-gray-50 border rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white"
                        placeholder="Product name" required>
                </div>

                <div>
                    <label for="subcategory_id"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subcategory</label>
                    <select name="subcategory_id" id="subcategory_id" required
                        class="bg-gray-50 border rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                        <option disabled selected>Select subcategory</option>
                        @foreach ($categories as $category)
                        <optgroup label="{{ $category->name }}">
                            @foreach ($category->subcategories as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                </div>

                <button type="submit" id="submitBtn"
                    class="mt-2 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg w-full px-5 py-2.5">
                    Add Item
                </button>
            </form>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // -------- DELETE MODAL --------
            let deleteForm = null;
            const deleteModal = document.getElementById("popup-modal");
            const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
            const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
            const closeDeleteModal = document.getElementById("closeDeleteModal");

            // Attach only to delete buttons
            document.querySelectorAll(".deleteBtn").forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    deleteForm = button.closest("form");
                    deleteModal.classList.remove("hidden");
                });
            });

            // Confirm deletion
            confirmDeleteBtn.addEventListener("click", () => {
                if (deleteForm) deleteForm.submit();
            });

            // Cancel deletion
            cancelDeleteBtn.addEventListener("click", () => {
                deleteForm = null;
                deleteModal.classList.add("hidden");
            });

            // Close modal via X button
            closeDeleteModal.addEventListener("click", () => {
                deleteForm = null;
                deleteModal.classList.add("hidden");
            });

            // Close modal if clicking outside
            deleteModal.addEventListener("click", e => {
                if (e.target === deleteModal) {
                    deleteForm = null;
                    deleteModal.classList.add("hidden");
                }
            });

            // -------- ADD / EDIT MODAL --------
            const addItemBtn = document.getElementById("addItemBtn");
            const crudModal = document.getElementById("crud-modal");
            const closeCrudModalBtn = document.getElementById("closeModal");
            const modalTitle = document.getElementById("modalTitle");
            const submitBtn = document.getElementById("submitBtn");
            const form = document.getElementById("crudForm");
            const nameInput = document.getElementById("name");
            const subcategorySelect = document.getElementById("subcategory_id");

            // Open Add Item modal
            addItemBtn.addEventListener("click", () => {
                crudModal.classList.remove("hidden");
                modalTitle.textContent = "Add New Item";
                submitBtn.textContent = "Add Item";
                form.action = "{{ route('inventory.store') }}";

                // Remove any existing PUT method
                form.querySelector("input[name='_method']")?.remove();
                form.reset();
            });

            // Close Add/Edit modal
            closeCrudModalBtn.addEventListener("click", () => crudModal.classList.add("hidden"));
            crudModal.addEventListener("click", e => {
                if (e.target === crudModal) crudModal.classList.add("hidden");
            });

            // Open Edit modal
            document.querySelectorAll(".editBtn").forEach(btn => {
                btn.addEventListener("click", () => {
                    const id = btn.dataset.id;
                    const name = btn.dataset.name;
                    const subcategoryId = btn.dataset.subcategoryId;

                    crudModal.classList.remove("hidden");
                    modalTitle.textContent = "Edit Item";
                    submitBtn.textContent = "Update Item";

                    nameInput.value = name;
                    subcategorySelect.value = subcategoryId;

                    form.action = `/inventory/${id}/update`;

                    // Add PUT method if not present
                    if (!form.querySelector("input[name='_method']")) {
                        const hiddenInput = document.createElement("input");
                        hiddenInput.type = "hidden";
                        hiddenInput.name = "_method";
                        hiddenInput.value = "PUT";
                        form.appendChild(hiddenInput);
                    }
                });
            });
            // -------- LIVE SEARCH FILTER --------
            const searchInput = document.getElementById('search_bar');
            const rows = document.querySelectorAll('table tbody tr');

            searchInput.addEventListener('input', function() {
                const filter = this.value.toLowerCase();

                rows.forEach(row => {
                    const cells = Array.from(row.querySelectorAll('td, th')).slice(0, -1);
                    const match = cells.some(cell => cell.textContent.toLowerCase().includes(filter));
                    row.style.display = match ? '' : 'none';
                });
            });

        });
    </script>
    @endpush