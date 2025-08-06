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

            api.rows({ search: 'applied' }).every(function () {
                const row = this.data();
                members.add(row[4]);
                divisions.add(row[5]);
                villages.add(row[6]);
                smallgroups.add(row[7]);
                const amount = parseFloat(row[2].replace(/,/g, '')) || 0;
                totalLoanAmount += amount;
            });

            $('.total-member-count').text(members.size);
            $('.total-division-count').text(divisions.size);
            $('.total-village-count').text(villages.size);
            $('.total-smallgroup-count').text(smallgroups.size);
            $('.total-loan-amount').text(totalLoanAmount.toFixed(2));
        }
    });

    // Clear previous filters to avoid duplicates
    $.fn.dataTable.ext.search = [];

    // Amount range filter (Min/Max Loan Amount)
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        const withMin = parseFloat($('#with1Min').val()) || 0;
        const withMax = parseFloat($('#with1Max').val()) || Infinity;
        const withdrawal = parseFloat(data[2].replace(/[^0-9.-]+/g, "")) || 0;
        return withdrawal >= withMin && withdrawal <= withMax;
    });

    // Filter button click - only trigger here
    $('#btnApplyFilters').on('click', function () {
        $("#loader").show();
        $(this).prop('disabled', true);

        // Set column filters manually
        tableLoanRep
            .column(5).search($('#divisionIdData').val() || '')    // Division
            .column(6).search($('#villageId').val() || '')         // Village
            .column(7).search($('#smallgroupId').val() || '');     // Small Group

        setTimeout(() => {
            tableLoanRep.draw(); // Trigger filters

            $("#loader").hide();
            $('#btnApplyFilters').prop('disabled', false);
        }, 3000);
    });

    // ------------------- Dropdown AJAX for Village & Small Group -------------------

    $("body").on("change", '#divisionIdData', function () {
        $("#loader").show();
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
                if (response.code == 200) {
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
