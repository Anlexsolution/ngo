$(document).ready(function () {
    $('.selectize').selectize();
    $('#txtDivision').selectize();
    $('#txtVillage').selectize();
    $('#txtSmallGroup').selectize();
    $('#showMember').dataTable();
});


//Get VIllage
$('body').on('change', '#txtDivision', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);

    var txtDivision = $('#txtDivision').val();
    formData.append('txtDivision', txtDivision);

    var txtMeetingType = $('#txtMeetingType').val();
    formData.append('txtMeetingType', txtMeetingType);

    if (txtDivision == '') {
        $.alert({
            title: "Error!",
            content: "Please select the division",
            type: "red",
            theme: 'modern',
            buttons: {
                okay: {
                    text: "Okay",
                    btnClass: "btn-red",
                    action: function () {
                        $("#loader").hide();
                    },
                },
            },
        });
        return false;
    }

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestDiv(formData);
    });
});

function makeAjaxRequestDiv(formData) {
    $.ajax({
        url: "/get-meeting-village-data",
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
                // Village dropdown
                if ($("#txtVillage")[0].selectize) {
                    $("#txtVillage")[0].selectize.destroy();
                }
                $("#txtVillage").empty().append(response.villageOption);
                $("#txtVillage").selectize();

                // Populate members
                if ($('#txtMeetingType').val() == 'Division Meeting') {
                    const tableId = '#showMember';

                    // If DataTable already initialized, use its API
                    if ($.fn.DataTable.isDataTable(tableId)) {
                        const table = $(tableId).DataTable();
                        table.clear();

                        response.getMemberData.forEach((member, index) => {
                            const fullName = `${member.title} ${member.firstName} ${member.lastName}`;
                            table.row.add([
                                index + 1,
                                fullName,
                                member.nicNumber,
                                member.oldAccountNumber,
                                `<input type="checkbox" class="absent-checkbox" data-id="${member.id}">`,
                                `<textarea class="form-control remarks-textarea" data-id="${member.id}"></textarea>`
                            ]);
                        });

                        table.draw();
                    } else {
                        // First-time initialize
                        const tbody = $(tableId + ' tbody');
                        tbody.empty();

                        response.getMemberData.forEach((member, index) => {
                            const fullName = `${member.title} ${member.firstName} ${member.lastName}`;
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${fullName}</td>
                                    <td>${member.nicNumber}</td>
                                    <td>${member.oldAccountNumber}</td>
                                    <td><input type="checkbox" class="absent-checkbox" data-id="${member.id}"></td>
                                    <td><textarea class="form-control remarks-textarea" data-id="${member.id}"></textarea></td>
                                </tr>
                            `);
                        });

                        $(tableId).DataTable();
                    }
                }
            } else {
                $("#txtVillage").empty();
                $("#txtVillage").append('<option value="">Select Village</option>');
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}

//Get VIllage


//Get Smalllgroup
$('body').on('change', '#txtVillage', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtDivision = $('#txtDivision').val();
    formData.append('txtDivision', txtDivision);

    var txtVillage = $('#txtVillage').val();
    formData.append('txtVillage', txtVillage);

    var txtMeetingType = $('#txtMeetingType').val();
    formData.append('txtMeetingType', txtMeetingType);

    if (txtDivision == '') {
        $.alert({
            title: "Error!",
            content: "Please select the division",
            type: "red",
            theme: 'modern',
            buttons: {
                okay: {
                    text: "Okay",
                    btnClass: "btn-red",
                    action: function () {
                        $("#loader").hide();
                    },
                },
            },
        });
        return false;
    }

    if (txtVillage == '') {
        $.alert({
            title: "Error!",
            content: "Please select the village",
            type: "red",
            theme: 'modern',
            buttons: {
                okay: {
                    text: "Okay",
                    btnClass: "btn-red",
                    action: function () {
                        $("#loader").hide();
                    },
                },
            },
        });
        return false;
    }

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestSmall(formData);
    });

});

function makeAjaxRequestSmall(formData) {
    $.ajax({
        url: "/get-meeting-smallgroup-data",
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
                if ($("#txtSmallGroup")[0].selectize) {
                    $("#txtSmallGroup")[0].selectize.destroy();
                }
                $("#txtSmallGroup").empty().append(response.villageOption);
                $("#txtSmallGroup").selectize();

                // Populate members
                if ($('#txtMeetingType').val() == 'Village Meeting') {
                    const tableId = '#showMember';

                    // If DataTable already initialized, use its API
                    if ($.fn.DataTable.isDataTable(tableId)) {
                        const table = $(tableId).DataTable();
                        table.clear();

                        response.getMemberData.forEach((member, index) => {
                            const fullName = `${member.title} ${member.firstName} ${member.lastName}`;
                            table.row.add([
                                index + 1,
                                fullName,
                                member.nicNumber,
                                member.oldAccountNumber,
                                `<input type="checkbox" class="absent-checkbox" data-id="${member.id}">`,
                                `<textarea class="form-control remarks-textarea" data-id="${member.id}"></textarea>`
                            ]);
                        });

                        table.draw();
                    } else {
                        // First-time initialize
                        const tbody = $(tableId + ' tbody');
                        tbody.empty();

                        response.getMemberData.forEach((member, index) => {
                            const fullName = `${member.title} ${member.firstName} ${member.lastName}`;
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${fullName}</td>
                                    <td>${member.nicNumber}</td>
                                    <td>${member.oldAccountNumber}</td>
                                    <td><input type="checkbox" class="absent-checkbox" data-id="${member.id}"></td>
                                    <td><textarea class="form-control remarks-textarea" data-id="${member.id}"></textarea></td>
                                </tr>
                            `);
                        });

                        $(tableId).DataTable();
                    }
                }
            } else {
                $("#txtSmallGroup").empty();
                $("#txtSmallGroup").append('<option value="">Select Smallgroup</option>');
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}
//Get Smalllgroup

//Get Smalllgroup Table Data
$('body').on('change', '#txtSmallGroup', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtSmallGroup = $('#txtSmallGroup').val();
    formData.append('txtSmallGroup', txtSmallGroup);


    var txtMeetingType = $('#txtMeetingType').val();
    formData.append('txtMeetingType', txtMeetingType);

    if (txtSmallGroup == '') {
        $.alert({
            title: "Error!",
            content: "Please select the smallgroup",
            type: "red",
            theme: 'modern',
            buttons: {
                okay: {
                    text: "Okay",
                    btnClass: "btn-red",
                    action: function () {
                        $("#loader").hide();
                    },
                },
            },
        });
        return false;
    }

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestSmallGroupData(formData);
    });

});

function makeAjaxRequestSmallGroupData(formData) {
    $.ajax({
        url: "/get-meeting-smallgroup-data-table",
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
                // Populate members
                if ($('#txtMeetingType').val() == 'Group Meeting') {
                    const tableId = '#showMember';

                    // If DataTable already initialized, use its API
                    if ($.fn.DataTable.isDataTable(tableId)) {
                        const table = $(tableId).DataTable();
                        table.clear();

                        response.getMemberData.forEach((member, index) => {
                            const fullName = `${member.title} ${member.firstName} ${member.lastName}`;
                            table.row.add([
                                index + 1,
                                fullName,
                                member.nicNumber,
                                member.oldAccountNumber,
                                `<input type="checkbox" class="absent-checkbox" data-id="${member.id}">`,
                                `<textarea class="form-control remarks-textarea" data-id="${member.id}"></textarea>`
                            ]);
                        });

                        table.draw();
                    } else {
                        // First-time initialize
                        const tbody = $(tableId + ' tbody');
                        tbody.empty();

                        response.getMemberData.forEach((member, index) => {
                            const fullName = `${member.title} ${member.firstName} ${member.lastName}`;
                            tbody.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${fullName}</td>
                                    <td>${member.nicNumber}</td>
                                    <td>${member.oldAccountNumber}</td>
                                    <td><input type="checkbox" class="absent-checkbox" data-id="${member.id}"></td>
                                    <td><textarea class="form-control remarks-textarea" data-id="${member.id}"></textarea></td>
                                </tr>
                            `);
                        });

                        $(tableId).DataTable();
                    }
                }
            } else {
                $("#txtSmallGroup").empty();
                $("#txtSmallGroup").append('<option value="">Select Smallgroup</option>');
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}
//Get Smalllgroup Table Data


$('body').on('change', '#txtMeetingType', function () {
    var txtMeetingType = $(this).val();
    if (txtMeetingType == 'Group Meeting') {
        $('#btnShowDivision').removeClass('d-none');
        $('#btnShowVIllage').removeClass('d-none');
        $('#btnShowSmallgroup').removeClass('d-none');
    } else if (txtMeetingType == 'Village Meeting') {
        $('#btnShowDivision').removeClass('d-none');
        $('#btnShowVIllage').removeClass('d-none');
        $('#btnShowSmallgroup').addClass('d-none');
    } else if (txtMeetingType == 'Division Meeting') {
        $('#btnShowDivision').removeClass('d-none');
        $('#btnShowVIllage').addClass('d-none');
        $('#btnShowSmallgroup').addClass('d-none');
    }
});


$('body').on('click', '#btnSaveMeeting', function () {
    $("#loader").show();
    const formData = new FormData();

    // CSRF Token (Laravel)
    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);

    // Meeting Info
    formData.append('meetingTitle', $('#txtMeetingTitle').val());
    formData.append('meetingDate', $('#txtMeetingDate').val());
    formData.append('meetingTime', $('#txtMeetingTime').val());
    formData.append('resourcePerson', $('#txtResourcePerson').val());
    formData.append('resourcePosition', $('#txtResourcePosition').val());
    formData.append('resourceContactNo', $('#txtResourceContactNo').val());
    formData.append('meetingType', $('#txtMeetingType').val());
    formData.append('divisionId', $('#txtDivision').val());
    formData.append('villageId', $('#txtVillage').val());
    formData.append('smallGroupId', $('#txtSmallGroup').val());

    // === Collect Members Attendance + Remarks ===
    const memberData = [];
    $('#showMember tbody tr').each(function () {
        const $row = $(this);
        const memberId = $row.find('.absent-checkbox').data('id');
        const isAbsent = $row.find('.absent-checkbox').is(':checked') ? 1 : 0;
        const remarks = $row.find('.remarks-textarea').val();

        memberData.push({
            memberId: memberId,
            isAbsent: isAbsent,
            remarks: remarks
        });
    });

    // Append JSON version of members data
    formData.append('memberData', JSON.stringify(memberData));

    // === Send AJAX ===
    $.ajax({
        url: "/create-meeting",
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            $("#loader").hide();
            if (response.code == 200) {
                $.alert({
                    title: 'Success!',
                    content: 'Meeting created successfully!',
                    type: 'green',
                    theme: 'modern',
                    buttons: {
                        okay: {
                            text: "OK",
                            btnClass: "btn-green",
                            action: function () {
                                location.reload();
                            }
                        }
                    }
                });
            } else {
                showAlert("Error!", response.message || "Something went wrong!");
            }
        },
        error: function (xhr) {
            $("#loader").hide();
            console.error(xhr.responseText);
            showAlert("Error!", "Something went wrong while saving.");
        }
    });
});
