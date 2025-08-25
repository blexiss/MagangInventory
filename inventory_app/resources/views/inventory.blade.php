@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between p-4">
    <!-- Add Items Button -->
    <button type="button" id="addItemBtn"
        class="block rounded-lg border border-gray-300 bg-transparent px-5 py-2.5 text-sm text-gray-900 dark:border-gray-600 dark:bg-gray-800 dark:text-white">
        + Add Items
    </button>

    @include('partials.search')
</div>

<!-- Table -->
@include('partials.table')

<!-- Modal -->
@include('partials.add_items')
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const addItemBtn = document.getElementById("addItemBtn");
    const modal = document.getElementById("crud-modal");
    const closeModalBtn = document.getElementById("closeModal");

    addItemBtn.addEventListener("click", () => modal.classList.remove("hidden"));
    closeModalBtn.addEventListener("click", () => modal.classList.add("hidden"));
    modal.addEventListener("click", (e) => { if(e.target===modal) modal.classList.add("hidden"); });
});
</script>
@endpush
