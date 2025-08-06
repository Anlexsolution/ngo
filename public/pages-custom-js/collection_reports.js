$(document).ready(function () {
    $('.selectize').selectize();
    $('#villageId').selectize();
    $('#smallgroupId').selectize();



 var tableOpening = $('#collectionReportTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
             {
                extend: 'excelHtml5',
                title: 'Collection Report',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4,5,6,7,8,9,10]
                }
            }
        ],
        scrollX: true,
        scrollY: '400px',
        scrollCollapse: true,
        footerCallback: function (row, data, start, end, display) {
            const api = this.api();

            const collectors = new Set();
            const members = new Set();
            const divisions = new Set();
            const villages = new Set();
            const smallgroups = new Set();
            let totalAmount = 0;

            api.rows({ search: 'applied' }).every(function () {
                const row = this.data();

                 const getCellText = (cell) => {
            return $('<div>').html(cell).text().trim();
        };

                collectors.add(row[2]); // Collection By
                members.add(row[3]);    // Member Name
                  divisions.add(getCellText(row[4]));
        villages.add(getCellText(row[5]));
        smallgroups.add(getCellText(row[6]));

                const amount = parseFloat(row[13].replace(/,/g, '')) || 0;
                totalAmount += amount;
            });

            $('.total-collector-count').text(collectors.size);
            $('.total-member-count').text(members.size);
            $('.total-division-count').text(divisions.size);
            $('.total-village-count').text(villages.size);
            $('.total-smallgroup-count').text(smallgroups.size);
            $('.total-amount-count').text(totalAmount.toFixed(2));
        }
    });

    // Clear any existing custom filters to avoid duplicates
    $.fn.dataTable.ext.search = [];

    // Custom filter for amount range
    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        let minAmount = parseFloat($('#with1Min').val()) || 0;
        let maxAmount = parseFloat($('#with1Max').val()) || Infinity;

        let withdrawal = parseFloat(data[9].replace(/[^0-9.-]+/g, "")) || 0;
        return withdrawal >= minAmount && withdrawal <= maxAmount;
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

    // Remove all input or change event listeners that trigger draw
    // (You can remove or comment out previous .on('keyup change') or .on('change') calls for these inputs)

    // Filter button click handler
    $('#btnApplyFilters').on('click', function () {
        $("#loader").show();
        $(this).prop('disabled', true);

        // Set column searches from dropdown filters
        tableOpening
            .column(2).search($('#fieldOfficerData').val() || '')
            .column(4).search($('#divisionIdData').val() || '')
            .column(5).search($('#villageId').val() || '')
            .column(6).search($('#smallgroupId').val() || '');

        setTimeout(() => {
            tableOpening.draw();

            $("#loader").hide();
            $('#btnApplyFilters').prop('disabled', false);
        }, 3000); // 3-second loader delay
    });

    // Ajax handlers for dynamic dropdown updates on division and village change (keep unchanged)

    $("body").on("change", '#divisionIdData', function () {
        $("#loader").show();
        var formData = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        formData.append("_token", CSRF_TOKEN);

        var divisionName = $(this).val();
        formData.append('divisionName', divisionName);

        getUserLocation().then(({ latitude, longitude }) => {
            formData.append('latitude', latitude);
            formData.append('longitude', longitude);
            makeAjaxRequestVillage(formData);
        });

        // We do NOT do tableOpening.column(4).search(...) here anymore
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
                $("#loader").hide();
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
                }, ); // 3-second delay here as well
            },
            error: function (xhr, status, error) {
                setTimeout(function () {
                    $("#loader").hide();
                    console.error("Error:", error);
                    showAlert("Error!", "Something went wrong!");
                }, );
            }
        });
    }
});
