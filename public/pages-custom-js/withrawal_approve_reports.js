$(document).ready(function () {
    $("#loader").show();
    $('.selectize').selectize();
    $('#villageId').selectize();
    $('#smallgroupId').selectize();


        var tableOpening = $('#tableWithApproveTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
             {
                extend: 'excelHtml5',
                title: 'withdrawal Report',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4,5,6,7,8,9]
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
            let totalSavAmount = 0;

            api.rows({ search: 'applied' }).every(function () {
                const row = this.data();
                members.add(row[1]);    // Member Name
                divisions.add(row[5]);  // Division
                villages.add(row[6]);   // Village
                smallgroups.add(row[7]); // Small Group

                // Remove commas, parse amount as float
                const amount = parseFloat(row[2].replace(/,/g, '')) || 0;
                totalSavAmount += amount;
            });

            // Update summary counts
            $('.total-member-count').text(members.size);
            $('.total-division-count').text(divisions.size);
            $('.total-village-count').text(villages.size);
            $('.total-smallgroup-count').text(smallgroups.size);
            $('.total-amount').text(totalSavAmount.toFixed(2));
        }
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        var withMin = parseFloat($('#with1Min').val()) || 0;
        var withMax = parseFloat($('#with1Max').val()) || Infinity;

        // Adjust the column index if needed (14 = 15th column)
        var withdrawal = parseFloat(data[2].replace(/[^0-9.-]+/g, "")) || 0;

        return withdrawal >= withMin && withdrawal <= withMax;
    });

    // Redraw table on input
$("#btnApplyFilters").on("click", function (e) {
    e.preventDefault();

    $("#loader").show();

    setTimeout(function () {
        // Apply all filters after 3 seconds
        var division = $("#divisionIdData").val();
        var village = $("#villageId").val();
        var smallgroup = $("#smallgroupId").val();
        var profession = $("#txtProfession").val();
        var withMin = parseFloat($("#with1Min").val()) || 0;
        var withMax = parseFloat($("#with1Max").val()) || Infinity;

        // Division = column 5, Village = 6, SmallGroup = 7, Profession = 8
        tableOpening.column(5).search(division);
        tableOpening.column(6).search(village);
        tableOpening.column(7).search(smallgroup);
        tableOpening.column(8).search(profession);

        // Force withdrawal amount redraw (handled via DataTable.ext.search)
        tableOpening.draw();

        $("#loader").hide();
    }, 3000);
});

    $("body").on("change", '#divisionIdData', function () {
        $("#loader").show();
        var formData = new FormData();

        // Get the CSRF token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        formData.append("_token", CSRF_TOKEN);
        // Get the CSRF token

        var status = $(this).val();
        formData.append('divisionName', status);

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
                    $("#villageId").empty();
                    $("#villageId").append('<option value="">Select Village</option>');
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
    $("#loader").hide();
});
