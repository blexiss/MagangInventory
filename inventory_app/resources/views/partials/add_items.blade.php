<!-- Modal -->
<div id="crud-modal" class="hidden fixed inset-0 z-50 flex justify-center items-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-lg shadow-sm p-5 dark:bg-gray-700 w-full max-w-md">
        <div class="flex justify-between items-center border-b pb-2 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Item</h3>
            <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">✕</button>
        </div>

        <form action="{{ route('inventory.store') }}" method="POST" class="mt-4 grid gap-4">
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

            <button type="submit" class="mt-2 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg w-full px-5 py-2.5">
                Add Item
            </button>
        </form>
    </div>
</div>
