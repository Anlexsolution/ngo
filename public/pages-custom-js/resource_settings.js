$(document).ready(function () {
    $('.selectize').selectize();
    $('#txtDivision').selectize();
    $('#txtVillage').selectize();
    $('#txtMainQualification').selectize();
    $('#txtSubQualification').selectize();
});


$("body").on("change", '#txtDivision', function () {
    $("#loader").show();
    var formData = new FormData();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);

    var divisionId = $(this).val();
    formData.append('divisionId', divisionId);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestVillage(formData);
    });

    // We do NOT do tableOpening.column(4).search(...) here anymore
});

function makeAjaxRequestVillage(formData) {
    $.ajax({
        url: "/get-village-data-resource",
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
                if ($("#txtVillage")[0].selectize) {
                    $("#txtVillage")[0].selectize.destroy();
                }
                $("#txtVillage").empty().append(response.villageOption);
                $("#txtVillage").selectize();
            } else {
                $("#txtVillage").empty().append('<option value="">Select Village</option>');
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


$("body").on("change", '#txtMainQualification', function () {
    $("#loader").show();
    var formData = new FormData();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);

    var quaIsd = $(this).val();
    formData.append('quaIsd', quaIsd);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestSubQuali(formData);
    });

    // We do NOT do tableOpening.column(4).search(...) here anymore
});

function makeAjaxRequestSubQuali(formData) {
    $.ajax({
        url: "/get-sub-qualification-data",
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
                if ($("#txtSubQualification")[0].selectize) {
                    $("#txtSubQualification")[0].selectize.destroy();
                }
                $("#txtSubQualification").empty().append(response.subquaOption);
                $("#txtSubQualification").selectize();
            } else {
                $("#txtSubQualification").empty().append('<option value="">Select Sub Qualification</option>');
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


$('body').on('click', '#btnSaveResource', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);

    // Get form values
    var txtFullName = $('#txtFullName').val();
    var txtDivision = $('#txtDivision').val();
    var txtVillage = $('#txtVillage').val();
    var txType = $('#txType').val();
    var txtDesignation = $('#txtDesignation').val();
    var txtMainQualification = $('#txtMainQualification').val();
    var txtSubQualification = $('#txtSubQualification').val();
    var txtDateOfBirth = $('#txtDateOfBirth').val();
    var txtNic = $('#txtNic').val();
    var txtContactNo = $('#txtContactNo').val();
    var txtWhatsappNo = $('#txtWhatsappNo').val();
    var txtaddress = $('#txtaddress').val();

    // Append to formData
    formData.append('txtFullName', txtFullName);
    formData.append('txtDivision', txtDivision);
    formData.append('txtVillage', txtVillage);
    formData.append('txType', txType);
    formData.append('txtDesignation', txtDesignation);
    formData.append('txtMainQualification', txtMainQualification);
    formData.append('txtSubQualification', txtSubQualification);
    formData.append('txtDateOfBirth', txtDateOfBirth);
    formData.append('txtNic', txtNic);
    formData.append('txtContactNo', txtContactNo);
    formData.append('txtWhatsappNo', txtWhatsappNo);
    formData.append('txtaddress', txtaddress);

    // Basic validation
    if (txtFullName === '' || txtDivision === '' || txType === '' || txtDesignation === '') {
        $.alert({
            title: "Error!",
            content: "Please fill all required fields (Full Name, Division, Type, Designation)",
            type: "red",
            theme: 'modern',
            buttons: {
                okay: {
                    text: "Okay",
                    btnClass: "btn-red",
                    action: function () {
                        $("#loader").hide();
                    }
                }
            }
        });
        return false;
    }

    // Optionally add location tracking (same as your meeting type example)
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequest(formData);
    }).catch(() => {
        makeAjaxRequest(formData);
    });
});

// Common AJAX function
function makeAjaxRequest(formData) {
    $.ajax({
        url: "/add-resource-person", // <-- Change to your actual route
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            $("#loader").hide();
            handleResponse(response); // Custom function to handle success
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        }
    });
}
