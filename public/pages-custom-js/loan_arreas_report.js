$(document).ready(function () {


var tableLoanRep = $('#loanReportTable').DataTable({
    dom: 'Bfrtip',
    buttons: [  {
                extend: 'excelHtml5',
                title: 'Loan Report',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4,5,6,7,8,9]
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
        let totalLoanAmount = 0;
        let loanArreasAmount = 0;

        api.rows({ search: 'applied' }).every(function () {
            const row = this.data();
            members.add(row[4]);        // Member Name
            divisions.add(row[5]);      // Division
            villages.add(row[6]);       // Village
            smallgroups.add(row[7]);    // Small Group

            const amount = parseFloat(row[2].replace(/,/g, '')) || 0;
            totalLoanAmount += amount;

            const arrears = parseFloat(row[3].replace(/,/g, '')) || 0;
            loanArreasAmount += arrears;
        });

        $('.total-member-count').text(members.size);
        $('.total-division-count').text(divisions.size);
        $('.total-village-count').text(villages.size);
        $('.total-smallgroup-count').text(smallgroups.size);
        $('.total-loan-amount').text(totalLoanAmount.toFixed(2));
        $('.total-loan-arreas-amount').text(loanArreasAmount.toFixed(2));
    }
});

// Loan Amount Range Filter (custom filter function)
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    if (!window.__loanFilterRange) return true;

    const loanAmount = parseFloat(data[2].replace(/[^0-9.-]+/g, '')) || 0;
    return loanAmount >= window.__loanFilterRange.minLoan &&
           loanAmount <= window.__loanFilterRange.maxLoan;
});

// Filter on button click with loader
$('#btnApplyFilters').on('click', function (e) {
    e.preventDefault();
    $("#loader").show();

    setTimeout(function () {
        const division = $('#divisionIdData').val();
        const village = $('#villageId').val();
        const smallgroup = $('#smallgroupId').val();
        const minLoan = parseFloat($('#with1Min').val()) || 0;
        const maxLoan = parseFloat($('#with1Max').val()) || Infinity;

        // Save range filter globally
        window.__loanFilterRange = { minLoan, maxLoan };

        // Apply column search filters
        tableLoanRep.column(5).search(division || '', true, false);   // Division
        tableLoanRep.column(6).search(village || '', true, false);    // Village
        tableLoanRep.column(7).search(smallgroup || '', true, false); // Small Group

        tableLoanRep.draw(); // Redraw table with all filters

        $("#loader").hide();
    }, 3000);
});

// Division -> Load Villages
$("body").on("change", '#divisionIdData', function () {
    $("#loader").show();
    var formData = new FormData();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

    formData.append("_token", CSRF_TOKEN);
    var division = $(this).val();
    formData.append('divisionName', division);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestVillage(formData);
    });
});

// Village -> Load Small Groups
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

// AJAX: Load Villages
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
            $("#loader").hide();
            if (response.code === 200) {
                if ($("#villageId")[0].selectize) {
                    $("#villageId")[0].selectize.destroy();
                }
                $("#villageId").empty().append(response.villageOption);
                $("#villageId").selectize();
            } else {
                $("#villageId").empty().append('<option value="">Select Village</option>');
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}

// AJAX: Load Small Groups
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
            setTimeout(function () {
                if (response.code === 200) {
                    if ($("#smallgroupId")[0].selectize) {
                        $("#smallgroupId")[0].selectize.destroy();
                    }
                    $("#smallgroupId").empty().append(response.smallOption);
                    $("#smallgroupId").selectize();
                } else {
                    $("#smallgroupId").empty().append('<option value="">Select Small Group</option>');
                }
                $("#loader").hide();
            }, 3000);
        },
        error: function (xhr, status, error) {
            setTimeout(function () {
                $("#loader").hide();
                console.error("Error:", error);
                showAlert("Error!", "Something went wrong!");
            }, 3000);
        }
    });
}

    $('.selectize').selectize();
    $('#villageId').selectize();
    $('#smallgroupId').selectize();
});
