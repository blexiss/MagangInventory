<form id="editForm" method="POST" class="mt-4 grid gap-4">
    @csrf
    @method('PUT') <!-- supaya bisa update -->

    <div>
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
        <input type="text" name="name" id="edit_name" 
               class="bg-gray-50 border rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white" 
               required>
    </div>

    <div>
        <label for="subcategory_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subcategory</label>
        <select name="subcategory_id" id="edit_subcategory_id" required
                class="bg-gray-50 border rounded-lg w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:text-white">
            <option disabled>Select subcategory</option>
            @foreach($categories as $category)
                <optgroup label="{{ $category->name }}">
                    @foreach($category->subcategories as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
    </div>

    <button type="submit" 
            class="mt-2 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg w-full px-5 py-2.5">
        Update Item
    </button>
</form>
