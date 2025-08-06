$(document).ready(function () {
    $('.selectize').selectize();
    $('#villageId').selectize();
    $('#smallgroupId').selectize();
    // Initialize table #tableMemberReport (if needed separately)
    $('#tableMemberReport').DataTable({
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdfHtml5'],
        scrollX: true,
        scrollY: '400px',
        scrollCollapse: true
    });

    // Initialize main report table #tableMemberReports
    var tableMemRep = $('#tableMemberReports').DataTable({
        dom: 'Bfrtip',
        buttons: [{
            extend: 'excelHtml5',
            title: 'Member Report',
            exportOptions: {
                columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 13]
            }
        }],
        scrollX: true,
        scrollY: '400px',
        scrollCollapse: true,
    footerCallback: function (row, data, start, end, display) {
    const api = this.api();
    const members = new Set();
    const divisions = new Set();
    const villages = new Set();
    const smallgroups = new Set();
    let totalSavAmount = 0, otherAm = 0, totalDeath = 0, totaalloan1 = 0;

    // Loop through each visible row
    api.rows({ search: 'applied' }).every(function () {
        const row = this.data();

        // Extract text from HTML if cell has <a> tags
        const getCellText = (cell) => {
            return $('<div>').html(cell).text().trim();
        };

        // Add unique values
        members.add(getCellText(row[2]));
        divisions.add(getCellText(row[4]));
        villages.add(getCellText(row[5]));
        smallgroups.add(getCellText(row[6]));

        // Parse financial columns safely
        const parseMoney = val => parseFloat(getCellText(val).replace(/,/g, '')) || 0;

        totalSavAmount += parseMoney(row[8]);  // Savings
        otherAm += parseMoney(row[9]);         // Other Income
        totalDeath += parseMoney(row[10]);     // Death Sub
        totaalloan1 += parseMoney(row[11]);    // Loan
    });

    // Update summary stats
    $('.total-member-count').text(members.size);
    $('.total-division-count').text(divisions.size);
    $('.total-village-count').text(villages.size);
    $('.total-smallgroup-count').text(smallgroups.size);
    $('.total-savings-amount').text(totalSavAmount.toFixed(2));
    $('.total-other-amount').text(otherAm.toFixed(2));
    $('.total-death-amount').text(totalDeath.toFixed(2));
    $('.total-loan1-amount').text(totaalloan1.toFixed(2));
}
    });

             $('.col-toggle').on('change', function () {
                const colIndex = $(this).data('index');
                const column = tableMemRep.column(colIndex);
                column.visible(this.checked);
            });

            $("#btnApplyFilters").on("click", function (e) {
    e.preventDefault();

    // Show loader
    $("#loader").show();

    // Delay 3 seconds, then apply filters
    setTimeout(function () {
        tableMemRep.draw(); // Redraw table with filters
        $("#loader").hide(); // Hide loader after 3s
        $('#collapseExample').collapse('hide'); // Optional: collapse filter box
    }, 3000);
});

});

$('#exportToPdf').click(function () {
    const table = $('#tableMemberReports').DataTable();
    const data = [];

    // Get filtered rows
    table.rows({ search: 'applied' }).every(function () {
        data.push(this.data());
    });

    // Get the title text
    const title = $('#datatable-title').text().trim();

    // Get column headers text from the table's <thead>
    const headers = [];
    $('#tableMemberReports thead th').each(function () {
        headers.push($(this).text().trim());
    });

    // Prepare form data
    const formData = new FormData();
    formData.append('_token', $('meta[name="csrf-token"]').attr("content"));
    formData.append('rows', JSON.stringify(data));
    formData.append('title', title);
    formData.append('headers', JSON.stringify(headers));  // <-- Send headers too

    $.ajax({
        url: "/export-member-pdf",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        xhrFields: {
            responseType: 'blob'
        },
        success: function (response) {
            const blob = new Blob([response], { type: 'application/pdf' });
            const link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = 'member-report.pdf';
            link.click();
        },
        error: function () {
            alert('Failed to generate PDF');
        }
    });
});



 // Custom filter for date range
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        let minDateStr = $('#minDate').val();
        let maxDateStr = $('#maxDate').val();
        let dateStr = data[1]; // Date column index

        if (!dateStr) return true; // If date is missing, don't filter it out

        let tableDate = new Date(dateStr);
        if ((minDateStr === "" && maxDateStr === "") ||
            (minDateStr === "" && tableDate <= new Date(maxDateStr)) ||
            (new Date(minDateStr) <= tableDate && maxDateStr === "") ||
            (new Date(minDateStr) <= tableDate && tableDate <= new Date(maxDateStr))
        ) {
            return true;
        }
        return false;
    });

// Custom filter functions
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var loan1Min = parseFloat($('#loan1Min').val()) || 0;
    var loan1Max = parseFloat($('#loan1Max').val()) || Infinity;
    var loan2Min = parseFloat($('#loan2Min').val()) || 0;
    var loan2Max = parseFloat($('#loan2Max').val()) || Infinity;

    var loan1 = parseFloat(data[12].replace(/[^0-9.-]+/g, "")) || 0;
    var loan2 = parseFloat(data[13].replace(/[^0-9.-]+/g, "")) || 0;

    return loan1 >= loan1Min && loan1 <= loan1Max && loan2 >= loan2Min && loan2 <= loan2Max;
});

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var savingsMin = parseFloat($('#savingsMin').val()) || 0;
    var savingsMax = parseFloat($('#savingsMax').val()) || Infinity;

    var savings = parseFloat(data[8].replace(/[^0-9.-]+/g, "")) || 0;

    return savings >= savingsMin && savings <= savingsMax;
});

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var selectedDivision = $('#divisionIdData').val();
    if (selectedDivision && data[3] !== selectedDivision) {
        return false;
    }
    return true;
});

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var selectedVillage = $('#villageId').val();
    if (selectedVillage && data[4] !== selectedVillage) {
        return false;
    }
    return true;
});

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var selectedSmall = $('#smallgroupId').val();
    if (selectedSmall && data[5] !== selectedSmall) {
        return false;
    }
    return true;
});

$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    var selectedProfession = $('#txtProfession').val();
    if (selectedProfession && data[7] !== selectedProfession) { // Assuming profession is in column 8 (index 7)
        return false;
    }
    return true;
});




// Division dropdown change (also loads villages)
$("body").on("change", '#divisionIdData', function () {
    var formData = new FormData();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    formData.append('divisionName', $(this).val());

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestVillage(formData);
    });
});

// Village AJAX
function makeAjaxRequestVillage(formData) {
    $.ajax({
        url: "/get-village-data",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            // Force 3-second delay
            setTimeout(function () {
                if (response.code == 200) {
                    if ($("#villageId")[0].selectize) {
                        $("#villageId")[0].selectize.destroy();
                    }
                    $("#villageId").empty().append(response.villageOption);
                    $("#villageId").selectize();
                } else {
                    $("#villageId").empty().append('<option value="">Select Village</option>');
                }
                $("#loader").hide();
            });
        },
        error: function (xhr, status, error) {
            setTimeout(function () {
                $("#loader").hide();
                console.error("Error:", error);
                showAlert("Error!", "Something went wrong!");
            });
        }
    });
}

// Division dropdown change (also loads villages)
$("body").on("change", '#villageId', function () {
    var formData = new FormData();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    formData.append('divisionName', $('#divisionIdData').val());
    formData.append('villageId', $('#villageId').val());

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestSmallGroup(formData);
    });
});

// Village AJAX
function makeAjaxRequestSmallGroup(formData) {
    $.ajax({
        url: "/get-small-group-data",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            // Force 3-second delay
            setTimeout(function () {
                if (response.code == 200) {
                    if ($("#smallgroupId")[0].selectize) {
                        $("#smallgroupId")[0].selectize.destroy();
                    }
                    $("#smallgroupId").empty().append(response.smallOption);
                    $("#smallgroupId").selectize();
                } else {
                    $("#smallgroupId").empty().append('<option value="">Select Small Group</option>');
                }
                $("#loader").hide();
            });
        },
        error: function (xhr, status, error) {
            setTimeout(function () {
                $("#loader").hide();
                console.error("Error:", error);
                showAlert("Error!", "Something went wrong!");
            });
        }
    });
}
