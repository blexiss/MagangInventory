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
    <div class="relative overflow-x-auto shadow-md smx:rounded-lg">
       <div class="bg-white dark:bg-gray-900 px-2 py-2 flex items-center justify-between">
        
        <!-- Search -->
        <div class="relative">
            <label for="table-search" class="sr-only">Search</label>
            <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
            </div>
            <input type="text" id="table-search"
                class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 
                       focus:ring-blue-500 focus:border-blue-500 
                       dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white 
                       dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search for items">
        </div>

        <!-- Button -->
<button 
    class="inline-block rounded-sm border border-white-600 text-white bg-transparent 
           px-4 py-2 text-sm font-medium 
           hover:bg-white hover:text-gray-900
           focus:outline-none focus:ring-2 focus:ring-gray-900">
    Audit Logs
</button>

    </div>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">Product name</th>
                <th scope="col" class="px-6 py-3">Quantity</th>
                <th scope="col" class="px-6 py-3">Category</th>
                <th scope="col" id="status-header" class="px-6 py-3 cursor-pointer select-none">
                    Status ⬍
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
        { id: "102", name: "Canon Pixma G2020", quantity: 8, category: "Printer", status: "High" },
        { id: "11", name: "M2 MacBook Pro 17\"", quantity: 8, category: "Printer", status: "High" }
    ];

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

    const renderTable = () => {
        const tableBody = document.getElementById("table-body");
        tableBody.innerHTML = "";
        products.forEach(product => {
            const row = document.createElement("tr");
            row.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600";
            row.innerHTML = `
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${product.id}</td>
                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">${product.name}</td>
                <td class="px-6 py-4">${product.quantity}</td>
                <td class="px-6 py-4">${product.category}</td>
                <td class="px-6 py-4">${statusBadge(product.status)}</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a href="#" class="ml-2 font-medium text-red-600 dark:text-red-600 hover:underline">Delete</a>
                </td>
            `;
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
