@extends('layouts.app')

@section('content')
<!-- Table -->
@include('partials.table')

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
