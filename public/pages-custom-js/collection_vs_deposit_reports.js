$(document).ready(function(){
            var tableOpening = $('#collectionvsdeposittable').DataTable({
        dom: 'Bfrtip',
        buttons: [
          {
                extend: 'excelHtml5',
                title: 'Collection vs deposit Report',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
        ],
        scrollX: true,
        scrollY: '400px',
        scrollCollapse: true,
                footerCallback: function (row, data, start, end, display) {
            const api = this.api();

            // Initialize Sets for unique values
            const members = new Set();
            const divisions = new Set();
            const villages = new Set();
            const smallgroups = new Set();
            let totalDepositAmount = 0;
            let totalCollectionAmount = 0;

            api.rows({ search: 'applied' }).every(function () {
                const row = this.data();
                members.add(row[1]);    // Member Name
                divisions.add(row[5]);  // Division
                villages.add(row[6]);   // Village
                smallgroups.add(row[7]); // Small Group

                // Remove commas, parse amount as float
                const amount = parseFloat(row[4].replace(/,/g, '')) || 0;
                totalDepositAmount += amount;

                  const clamount = parseFloat(row[3].replace(/,/g, '')) || 0;
                totalCollectionAmount += clamount;
            });

            // Update summary counts
            $('.total-deposit-amount').text(totalDepositAmount.toFixed(2));
            $('.total-collection-amount').text(totalCollectionAmount.toFixed(2));
        }
    });
})
