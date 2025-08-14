<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Item Name</th>
                <th scope="col" class="px-6 py-3">Quantity</th>
                <th scope="col" class="px-6 py-3">Category</th>
                <th scope="col" id="status-header" class="px-6 py-3 cursor-pointer select-none">
                    Status 
                </th>
                <th scope="col" class="px-6 py-3 ">Action</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <!-- Rows will be inserted here -->
        </tbody>
    </table>
</div>

<script>
    let products = [
        { id: "1", name: "Epson L3110 EcoTank", quantity: 20, category: "Printer", status: "Low" },
        { id: "2", name: "HP LaserJet Pro", quantity: 15, category: "Printer", status: "In Stock" },
        { id: "3", name: "Canon Pixma G2020", quantity: 18, category: "Printer", status: "High" },
        { id: "4", name: "Nizaar GAY 17\"", quantity: 18, category: "Printer", status: "High" }
    ];

    const categoryBadge = (category) => {
  return `<span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">${category}</span>`;
};


    const statusPriority = {
        "Low": 1,        // Low
        "In Stock": 2,   // In Stock
        "High": 3        // Surplus
    };

    const statusBadge = (status) => {
        let text = "";
        let classes = "rounded-full border px-2.5 py-0.5 text-sm whitespace-nowrap ";

        switch (status) {
            case "Low":
                text = "Low";
                classes += "border-red-500 text-red-700 dark:text-red-300";
                break;
            case "In Stock":
                text = "In Stock";
                classes += "border-yellow-500 text-yellow-700 dark:text-yellow-300";
                break;
            case "High":
                text = "Surplus";
                classes += "border-green-500 text-green-700 dark:text-green-300";
                break;
            default:
                text = status;
                classes += "border-gray-500 text-gray-700 dark:text-gray-100";
        }

        return `<span class="${classes}">${text}</span>`;
    };

 // Modal Function
function showItemDetails(product) {
    const modal = document.getElementById("itemModal");
    const modalContent = document.getElementById("modalContent");

    modalContent.innerHTML = `
      <div>
        <div class="px-4 sm:px-0">
          <h3 class="text-base font-semibold text-white">Item Information</h3>
        </div>
        <div class="mt-6 border-t border-white/10">
          <dl class="divide-y divide-white/10">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium text-gray-100">Item Name</dt>
              <dd class="mt-1 text-sm text-gray-400 sm:col-span-2 sm:mt-0">${product.name}</dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium text-gray-100">ID</dt>
              <dd class="mt-1 text-sm text-gray-400 sm:col-span-2 sm:mt-0">${product.id}</dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium text-gray-100">Location</dt>
              <dd class="mt-1 text-sm text-gray-400 sm:col-span-2 sm:mt-0">Gedung G, Lantai 2</dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium text-gray-100">IP Address</dt>
              <dd class="mt-1 text-sm text-gray-400 sm:col-span-2 sm:mt-0">192.168.2.1</dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
              <dt class="text-sm font-medium text-gray-100">Note</dt>
              <dd class="mt-1 text-sm text-gray-400 sm:col-span-2 sm:mt-0 text-justify">${product.note || "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum"}</dd>
            </div>
          </dl>
        </div>
      </div>
    `;

    modal.classList.remove("hidden");
}

// Close modal when clicking the close button
document.getElementById("closeModal").addEventListener("click", () => {
    document.getElementById("itemModal").classList.add("hidden");
});

// Close modal when clicking outside the modal content
document.getElementById("itemModal").addEventListener("click", (e) => {
    if (e.target.id === "itemModal") {
        e.target.classList.add("hidden");
    }
});


// 2. Render Table
const renderTable = () => {
    const tableBody = document.getElementById("table-body");
    tableBody.innerHTML = "";
    products.forEach(product => {
        const row = document.createElement("tr");
        row.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600";
        row.innerHTML = `
            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${product.id}</td>
            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                <span class="cursor-pointer">${product.name}</span>
            <td class="px-6 py-4">${product.quantity}</td>
            <td class="px-6 py-4">${categoryBadge(product.category)}</td>
            <td class="px-6 py-4">${statusBadge(product.status)}</td>
            <td class="px-6 py-4 flex flex-col sm:flex-row gap-2">
            <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
            <a href="#" class="font-medium text-red-600 dark:text-red-600 hover:underline">Delete</a>
            </td>

        `;
                // Only the name cell triggers the modal
        const nameSpan = row.querySelector("td:nth-child(2) span");
        nameSpan.addEventListener("click", () => {
            showItemDetails(product);
        });
        tableBody.appendChild(row);
    });
};
    let sortAsc = true;

    document.getElementById("status-header").addEventListener("click", () => {
        products.sort((a, b) => {
            return sortAsc
                ? statusPriority[a.status] - statusPriority[b.status]
                : statusPriority[b.status] - statusPriority[a.status];
        });
        sortAsc = !sortAsc;
        renderTable();
    });

    renderTable();
</script>