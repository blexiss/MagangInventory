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
<div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
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
                        @if($item['status'] === 'Low') border-red-500 text-red-700 dark:text-red-300
                        @elseif($item['status'] === 'In Stock') border-green-500 text-green-700 dark:text-green-300
                        @elseif($item['status'] === 'High') border-green-500 text-green-700 dark:text-green-300
                        @endif">
                        {{ $item['status'] }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <!-- Tombol Edit -->
                    <button type="button"
                        class="editBtn font-medium text-blue-600 dark:text-blue-500 hover:underline mr-2"
                        data-id="{{ $item['id'] }}"
                        data-name="{{ $item['name'] }}"
                        data-subcategory-id="{{ $item['subcategory_id'] }}">
                        Edit
                    </button>

                    <!-- Tombol Delete -->
                    <form action="{{ route('inventory.destroy', $item['id']) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="font-medium text-red-600 dark:text-red-500 hover:underline"
                            onclick="return confirm('Yakin ingin menghapus item ini?')">
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

<!-- Modal Add/Edit Item -->
<div id="crud-modal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-lg shadow-sm p-5 dark:bg-gray-700 w-full max-w-md">
        <div class="flex justify-between items-center border-b pb-2 dark:border-gray-600">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-white">Add New Item</h3>
            <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">✕</button>
        </div>

        <form id="crudForm" action="{{ route('inventory.store') }}" method="POST" class="mt-4 grid gap-4">
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
