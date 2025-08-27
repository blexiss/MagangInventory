@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between p-4">
    <!-- Add Items Button -->
    <button type="button" id="addItemBtn"
        class="block rounded-lg border border-gray-300 bg-transparent px-5 py-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        + Add Item
    </button>
    @include('partials.search')
</div>

<!-- Table -->
<div class="relative mt-4 overflow-x-auto shadow-md sm:rounded-lg">
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
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th class="px-6 py-4" scope="row">{{ $loop->iteration }}</th>
                <td class="px-6 py-4">{{ $item['name'] }}</td>
                <td class="px-6 py-4">{{ $item['quantity'] }}</td>
                <td class="px-6 py-4">
                    <span
                        class="text-xs font-medium px-2 py-0.5 rounded
                        @if($item['category'] === 'Printing') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300
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
                        @if($item['status'] === 'Out of Stock') border-red-500 text-red-700 dark:text-red-300
                        @elseif($item['status'] === 'Low') border-yellow-500 text-yellow-700 dark:text-yellow-300
                        @elseif($item['status'] === 'In Stock') border-green-500 text-green-700 dark:text-green-300
                        @endif">
                        {{ $item['status'] }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <!-- Tombol Edit -->
                    <button type="button"
                        class="mr-2 font-medium text-blue-600 editBtn dark:text-blue-500 hover:underline"
                        data-id="{{ $item['id'] }}"
                        data-name="{{ $item['name'] }}"
                        data-subcategory-id="{{ $item['subcategory_id'] }}">
                        Edit
                    </button>

                    <!-- Tombol Delete -->
                    <form action="{{ route('inventory.destroy', $item['id']) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline">
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
                          d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400 dark:text-gray-200" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
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
<div id="crud-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/40 backdrop-blur-sm">
    <div class="w-full max-w-md p-5 bg-white rounded-lg shadow-sm dark:bg-gray-700">
        <div class="flex items-center justify-between pb-2 border-b dark:border-gray-600">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">Add New Item</h3>
            <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">✕</button>
        </div>

        <form id="crudForm" action="{{ route('inventory.store') }}" method="POST" class="grid gap-4 mt-4">
            @csrf
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                <input type="text" name="name" id="name" class="bg-gray-50 border rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" placeholder="Product name" required>
            </div>

            <div>
                <label for="subcategory_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subcategory</label>
                <select name="subcategory_id" id="subcategory_id" required class="bg-gray-50 border rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
                    <option disabled selected>Select subcategory</option>
                    @foreach($categories as $category)
                        <optgroup label="{{ $category->name }}">
                            @foreach($category->subcategories as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>

            <button type="submit" id="submitBtn" class="mt-2 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg w-full px-5 py-2.5">
                Add Item
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>

document.addEventListener("DOMContentLoaded", function() {
    let deleteForm; // store the form being deleted
    const deleteModal = document.getElementById("popup-modal");
    const confirmDeleteBtn = document.getElementById("confirmDeleteBtn");
    const cancelDeleteBtn = document.getElementById("cancelDeleteBtn");
    const closeDeleteModal = document.getElementById("closeDeleteModal");

    // Intercept all delete forms
    document.querySelectorAll("form[action*='inventory'][method='POST']").forEach(form => {
        const deleteButton = form.querySelector("button[type='submit']");
        deleteButton.addEventListener("click", function(e) {
            e.preventDefault();
            deleteForm = form; // save the current form
            deleteModal.classList.remove("hidden");
        });
    });

    // Confirm delete
    confirmDeleteBtn.addEventListener("click", () => {
        if(deleteForm) deleteForm.submit();
    });

    // Cancel delete
    cancelDeleteBtn.addEventListener("click", () => {
        deleteForm = null;
        deleteModal.classList.add("hidden");
    });

    // Close modal
    closeDeleteModal.addEventListener("click", () => {
        deleteForm = null;
        deleteModal.classList.add("hidden");
    });

    // Close modal if clicked outside
    deleteModal.addEventListener("click", e => {
        if(e.target === deleteModal){
            deleteForm = null;
            deleteModal.classList.add("hidden");
        }
    });
});


document.addEventListener("DOMContentLoaded", function() {
    const addItemBtn = document.getElementById("addItemBtn");
    const modal = document.getElementById("crud-modal");
    const closeModalBtn = document.getElementById("closeModal");
    const modalTitle = document.getElementById("modalTitle");
    const submitBtn = document.getElementById("submitBtn");
    const form = document.getElementById("crudForm");
    const nameInput = document.getElementById("name");
    const subcategorySelect = document.getElementById("subcategory_id");

    // Tombol Add
    addItemBtn.addEventListener("click", () => {
        modal.classList.remove("hidden");
        modalTitle.textContent = "Add New Item";
        submitBtn.textContent = "Add Item";
        form.action = "{{ route('inventory.store') }}";
        form.querySelector("input[name='_method']")?.remove(); // hapus PUT kalau ada
        form.reset();
    });

    // Tombol Close
    closeModalBtn.addEventListener("click", () => modal.classList.add("hidden"));
    modal.addEventListener("click", e => { if(e.target===modal) modal.classList.add("hidden"); });

    // Tombol Edit
    document.querySelectorAll(".editBtn").forEach(btn => {
        btn.addEventListener("click", () => {
            const id = btn.dataset.id;
            const name = btn.dataset.name;
            const subcategoryId = btn.dataset.subcategoryId;

            modal.classList.remove("hidden");
            modalTitle.textContent = "Edit Item";
            submitBtn.textContent = "Update Item";

            nameInput.value = name;
            subcategorySelect.value = subcategoryId;

            form.action = `/inventory/${id}/update`;

            // tambahkan input PUT kalau belum ada
            if (!form.querySelector("input[name='_method']")) {
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "_method";
                hiddenInput.value = "PUT";
                form.appendChild(hiddenInput);
            }
        });
    });
});
</script>
@endpush