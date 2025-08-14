<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inventory List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body class="bg-white dark:bg-gray-800 m-0 p-0">
<nav class="relative bg-gray-950/50 after:pointer-events-none after:absolute after:inset-x-0 after:bottom-0 after:h-px after:bg-white/10">
  <div class="mx-auto px-4 sm:px-6 lg:px-6">
    <div class="relative flex h-16 items-center justify-between">

        <!-- Item Details Modal (hidden by default) -->
<div id="itemModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
  <div class="bg-gray-900 rounded-lg w-full max-w-lg p-6 relative">
    <button id="closeModal" class="absolute top-3 right-3 text-white text-lg font-bold">&times;</button>
    <div id="modalContent">
      <!-- Dynamic content will be injected here -->
    </div>
  </div>
</div>


      <!-- Mobile menu button -->
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <button id="mobile-menu-button" type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-white/5 hover:text-white focus:outline focus:outline-2 focus:-outline-offset-1 focus:outline-indigo-500">
          <span class="sr-only">Open main menu</span>
          <!-- Hamburger open icon -->
          <svg class="block h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <!-- Hamburger close icon, hidden by default -->
          <svg class="hidden h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <!-- Left side: logo + nav links -->
      <div class="flex flex-1 items-center sm:items-stretch sm:justify-start space-x-6 pl-12 sm:pl-0">
        <div class="flex shrink-0 items-center">
          <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company" class="h-8 w-auto" />
        </div>
        <div class="hidden sm:flex space-x-4">
          <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white whitespace-nowrap">Dashboard</a>
          <a href="#" aria-current="page" class="rounded-md bg-gray-950/50 px-3 py-2 text-sm font-medium text-white whitespace-nowrap">Inventory</a>
          <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white whitespace-nowrap">Calendar</a>
          <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-white/5 hover:text-white whitespace-nowrap">Audit Logs</a>
        </div>
      </div>

      <!-- Right side: search bar -->
      <div class="relative ml-auto max-w-xs min-w-[100px] sm:min-w-[150px]">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
               xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
          </svg>
        </div>
        <input
          type="text"
          id="search_bar"
          class="block w-full rounded-lg border border-gray-300 bg-transparent px-10 pt-2 pb-2 text-sm text-gray-900 appearance-none dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-blue-500 focus:border-blue-600 focus:outline-none focus:ring-0 peer"
          placeholder=" "
        />
        <label
          for="search_bar"
          class="absolute top-2 z-10 origin-[0] px-2 text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75
                 peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:scale-100
                 peer-focus:top-2 peer-focus:-translate-y-4 peer-focus:scale-75
                 dark:text-gray-400 peer-focus:text-blue-600 peer-focus:dark:text-blue-500
                 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto start-1 bg-white dark:bg-gray-900"
        >
          Search ID or Items
        </label>
      </div>
    </div>

    <!-- Mobile menu (hidden by default) -->
    <div id="mobile-menu" class="hidden sm:hidden mt-2 space-y-1 px-4">
      <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Dashboard</a>
      <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-white bg-gray-950/50">Inventory</a>
      <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Calendar</a>
      <a href="#" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-white/5 hover:text-white">Audit Logs</a>
      <!-- Optional mobile search bar here if needed -->
    </div>
  </div>

  <script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');
    const openIcon = btn.querySelector('svg.block');
    const closeIcon = btn.querySelector('svg.hidden');

    btn.addEventListener('click', () => {
      menu.classList.toggle('hidden');
      openIcon.classList.toggle('hidden');
      closeIcon.classList.toggle('hidden');
    });
  </script>
</nav>



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
        { id: "100", name: "Epson L3110 EcoTank", quantity: 20, category: "Printer", status: "Low" },
        { id: "101", name: "HP LaserJet Pro", quantity: 15, category: "Printer", status: "In Stock" },
        { id: "102", name: "Canon Pixma G2020", quantity: 18, category: "Printer", status: "High" },
        { id: "11", name: "M2 MacBook Pro 17\"", quantity: 18, category: "Printer", status: "High" }
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
              <dt class="text-sm font-medium text-gray-100">Arrival Date</dt>
              <dd class="mt-1 text-sm text-gray-400 sm:col-span-2 sm:mt-0">Thursday, 14-08-2025</dd>
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
            <td class="px-6 py-4">
                <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                <a href="#" class="ml-2 font-medium text-red-600 dark:text-red-600 hover:underline">Delete</a>
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



    </div>
    <script>
        < script src = "../path/to/flowbite/dist/flowbite.min.js" >
    </script>
    </script>

</body>

</html>
