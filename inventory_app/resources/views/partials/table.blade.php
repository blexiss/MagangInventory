<div class="relative overflow-x-auto shadow-md sm:rounded-lg">

    <!-- Item Details Modal (Hidden) -->
    <div id="itemModal" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-gray-900 rounded-lg w-full max-w-lg p-6 relative">
            <button id="closeModal" class="absolute top-3 right-3 text-white text-lg font-bold">&times;</button>
            <div id="modalContent"></div>
        </div>
    </div>

    <!-- Table -->
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead id="table-head" class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 rounded-t-lg">
            <!-- Header Tabel di Generate oleh JS -->
        </thead>
        <tbody id="table-body">
            <!-- Baris di Render disini -->
        </tbody>
    </table>

</div>

<script>
    // Sample Data
    const products = [
        { id: "1", name: "HP LaserJet Pro", quantity: 20, category: "Printer", status: "Low" },
        { id: "2", name: "TP-Link AX3000", quantity: 15, category: "Router", status: "Low" },
        { id: "2", name: "Ruijie Reyee EG105W", quantity: 15, category: "AP", status: "Low" },
        { id: "3", name: "Camtrix V380 Pro", quantity: 18, category: "CCTV", status: "High" },
        { id: "4", name: "Nizar Pro Max 17\" 5090 Ti", quantity: 18, category: "PC", status: "High" }
    ];

    // Map main categories to colors
    const categoryColors = {
        "Printing": "bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300",
        "Monitoring": "bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300",
        "Networking": "bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300",
        "Workstation": "bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300"
    };

    // Map subcategories to main category
    const subCategoryToMain = {
        // Printing
        "Printer": "Printing",
        "Paper": "Printing",
        "Cartridge": "Printing",

        // Monitoring
        "CCTV": "Monitoring",
        "Coaxial": "Monitoring",

        // Networking
        "Router": "Networking",
        "Switch": "Networking",
        "AP":"Networking",
        "LAN": "Networking",

        //Workstation
        "Monitor": "Workstation",
        "Keyboard": "Workstation",
        "Mouse": "Workstation",
        "PC": "Workstation"
    };

    // Formatter functions
    function categoryBadge(subCategory) {
        const mainCategory = subCategoryToMain[subCategory] || "Other";
        const classes = categoryColors[mainCategory] || "bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300";
        return `<span class="text-xs font-medium px-2 py-0.5 rounded ${classes}">${subCategory}</span>`;
    }

    const statusPriority = { "Low": 1, "In Stock": 2, "High": 3 };

    function statusBadge(status) {
        let text = "";
        let classes = "rounded-full border px-2.5 py-0.5 text-sm whitespace-nowrap ";
        switch(status) {
            case "Low": text = "Low"; classes += "border-red-500 text-red-700 dark:text-red-300"; break;
            case "In Stock": text = "Medium"; classes += "border-yellow-500 text-yellow-700 dark:text-yellow-300"; break;
            case "High": text = "In Stock"; classes += "border-green-500 text-green-700 dark:text-green-300"; break;
            default: text = status; classes += "border-gray-500 text-gray-700 dark:text-gray-100";
        }
        return `<span class="${classes}">${text}</span>`;
    }

    // Column configuration
    const columns = [
        { key: "id", label: "ID" },
        { key: "name", label: "Item Name", clickable: true },
        { key: "quantity", label: "Quantity" },
        { key: "category", label: "Category", formatter: categoryBadge },
        { key: "status", label: "Status", formatter: statusBadge, sortable: true },
        { key: "actions", label: "Action", isAction: true }
    ];

    // Render Table Header
    function renderHeader() {
        const thead = document.getElementById("table-head");
        thead.innerHTML = "";
        const tr = document.createElement("tr");
        columns.forEach(col => {
            const th = document.createElement("th");
            th.scope = "col";
            th.className = "px-6 py-3 text-left cursor-pointer select-none";
            th.textContent = col.label;
            if(col.sortable && col.key === "status") th.id = "status-header";
            tr.appendChild(th);
        });
        thead.appendChild(tr);
    }

    // Render Table Rows
    function renderTable() {
        const tableBody = document.getElementById("table-body");
        tableBody.innerHTML = "";

        if(products.length === 0) {
            tableBody.innerHTML = `<tr>
                <td colspan="${columns.length}" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                    No products available
                </td>
            </tr>`;
            return;
        }

        products.forEach(product => {
            const row = document.createElement("tr");
            row.className = "bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600";

            columns.forEach(col => {
                const td = document.createElement("td");
                td.className = "px-6 py-4";

                if(col.formatter) td.innerHTML = col.formatter(product[col.key]);
                else if(col.isAction) td.innerHTML = `
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <a href="#" class="font-medium text-red-600 dark:text-red-600 hover:underline">Delete</a>
                `;
                else td.textContent = product[col.key];

                if(col.clickable) {
                    td.innerHTML = `<span class="cursor-pointer">${product[col.key]}</span>`;
                    td.querySelector("span").addEventListener("click", () => showItemDetails(product));
                }

                row.appendChild(td);
            });

            tableBody.appendChild(row);
        });
    }

    // Modal Function
function showItemDetails(product) {
    const modal = document.getElementById("itemModal");
    const modalContent = document.getElementById("modalContent");

    // Determine unique property based on subcategory
    let uniqueLabel = "Detail";
    let uniqueValue = "-";

    const subcategoryDetails = {
        // Monitoring
        "CCTV": { label: "IP Address", default: "192.168.2.100" },
        "Coaxial": { label: "Cable Length", default: "10m" },

        // Networking
        "Router": { label: "IP Address", default: "192.168.1.1" },
        "AP": { label: "IP Address", default: "192.168.1.1" },
        "Switch": { label: "IP Address", default: "192.168.1.2" },
        "LAN": { label: "Length", default: "10m" },

        // Workstation
        "PC": { label: "Processor", default: "Intel I5 10700K" },
        "Monitor": { label: "Monitor Size", default: "LED 24\"" },
        "Keyboard": { label: "Form Factor", default: "" },
        "Mouse": { label: "Mouse Type", default: "Wireless" },

        // Printing
        "Printer": { label: "Serial Number", default: "A4F9K2B7Q1" },
        "Paper": { label: "Paper Type", default: "A4" },
        "Cartridge": { label: "Cartridge Type", default: "Ink" }
    };

    if (subcategoryDetails[product.category]) {
        uniqueLabel = subcategoryDetails[product.category].label;
        uniqueValue = product.uniqueDetail || subcategoryDetails[product.category].default;
    }

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
                        <dd class="mt-1 text-sm text-gray-400 sm:col-span-2 sm:mt-0">${product.location || "Gedung G, Lantai 2"}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium text-gray-100">${uniqueLabel}</dt>
                        <dd class="mt-1 text-sm text-gray-400 sm:col-span-2 sm:mt-0">${uniqueValue}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium text-gray-100">Note</dt>
                        <dd class="mt-1 text-sm text-gray-400 sm:col-span-2 sm:mt-0 text-justify">${product.note || "No additional notes"}</dd>
                    </div>
                </dl>
            </div>
        </div>
    `;

    modal.classList.remove("hidden");
}


    // Close Modal
    document.getElementById("closeModal").addEventListener("click", () => {
        document.getElementById("itemModal").classList.add("hidden");
    });
    document.getElementById("itemModal").addEventListener("click", (e) => {
        if(e.target.id === "itemModal") e.target.classList.add("hidden");
    });

    // Status sorting
    let sortAsc = true;
    document.addEventListener("click", () => {
        const statusHeader = document.getElementById("status-header");
        if(statusHeader) {
            statusHeader.addEventListener("click", () => {
                products.sort((a,b) => sortAsc ? statusPriority[a.status]-statusPriority[b.status] : statusPriority[b.status]-statusPriority[a.status]);
                sortAsc = !sortAsc;
                renderTable();
            });
        }
    });

    // Initial render
    renderHeader();
    renderTable();
</script>

