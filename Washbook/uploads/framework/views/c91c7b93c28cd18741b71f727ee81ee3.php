<?php global $s_v_data, $user, $title, $salesData; ?>
<?= view( 'includes/head', $s_v_data ); ?>
<body>
    <!-- Header -->
    <?= view( 'includes/header', $s_v_data ); ?>

    <!-- Aside -->
    <?= view( 'includes/aside', $s_v_data ); ?>
    <!-- Main Content -->
    <main class="main-content">
        <div class="craft-container">
            <div class="row craft-page-head">
                <div class="col-md-6">
                    <h3><?=  $title ; ?></h3>
                    <p class="text-gray-500">View and export sales reports.</p>
                </div>
                <div class="col-md-6 header-right">
                    <button class="btn btn-primary" id="exportToExcel">Export to Excel</button>
                </div>
            </div>
            <div class="craft-card">
                <div class="table-holder">
                    <table class="datatable table" id="salesReportTable" data-auto-responsive="false">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Client</th>
                                <th>Amount / Comm.</th>
                                <th>Item / Services</th>
                                <th>Performed by</th>
                                <th>Payment Method</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Sales data will be populated here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <?= view( 'includes/footer', $s_v_data ); ?>
    <?= view( 'includes/scripts', $s_v_data ); ?>

    <!-- Include a library for exporting to Excel, e.g., SheetJS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.4/xlsx.full.min.js"></script>

    <script>
        // Fetch sales data from the server and populate the table
        fetchSalesData();

        function fetchSalesData() {
            fetch('/api/sales')
                .then(response => response.json())
                .then(data => {
                    // Populate the table body with the sales data
                    var tableBody = document.querySelector('#salesReportTable tbody');
                    tableBody.innerHTML = '';

                    data.forEach((sale, index) => {
                        var row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="text-center">${index + 1}</td>
                            <td>${sale.client.fullname}</td>
                            <td>${sale.total} / ${sale.commission}</td>
                            <td>${sale.item}</td>
                            <td>${sale.performedBy.join(', ')}</td>
                            <td>${sale.paymentMethod}</td>
                            <td>${sale.createdAt}</td>
                        `;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Error fetching sales data:', error);
                });
        }

        document.getElementById('exportToExcel').addEventListener('click', function() {
            exportToExcel();
        });

        function exportToExcel() {
            var worksheet = XLSX.utils.table_to_sheet(document.getElementById('salesReportTable'));
            var workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Sales Report');
            XLSX.writeFile(workbook, 'sales_report.xlsx');
        }
    </script>

</body>
</html>

<?php return;
