$(document).ready(function () {
    $('.selectize').selectize();
});

$('body').on('click', '.btnAprovalModalOpen', function () {
    var id = $(this).attr('data-id');
    $('#txtDonationId').val(id);
    $('#btnAprovalModal').modal('show');
});

$('body').on('click', '.btnRejectModalOpen', function () {
    var id = $(this).attr('data-id');
    $('#txtDonationRejectedId').val(id);
    $('#btnRejectModal').modal('show');
});

//Create Approval
$('body').on('click', '#btnAproval', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtAccount = $('#txtAccount').val();
    formData.append('txtAccount', txtAccount);

    var txtCheqNo = $('#txtCheqNo').val();
    formData.append('txtCheqNo', txtCheqNo);

    var txtApprovalReason = $('#txtApprovalReason').val();
    formData.append('txtApprovalReason', txtApprovalReason);

    var txtDonationId = $('#txtDonationId').val();
    formData.append('txtDonationId', txtDonationId);

    if (txtAccount == '') {
        $.alert({
            title: "Error!",
            content: "Please select the account",
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
        makeAjaxRequestapprove(formData);
    });

});

function makeAjaxRequestapprove(formData) {
    $.ajax({
        url: "/add-death-distribute-data",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            $("#loader").hide();
            handleResponse(response);
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}
////Create Approval


//Rjected Approval
$('body').on('click', '#btnRejected', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtRejectedReason = $('#txtRejectedReason').val();
    formData.append('txtRejectedReason', txtRejectedReason);

    var txtDonationRejectedId = $('#txtDonationRejectedId').val();
    formData.append('txtDonationRejectedId', txtDonationRejectedId);

    if (txtRejectedReason == '') {
        $.alert({
            title: "Error!",
            content: "Please enter the reason",
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
        makeAjaxRequestrejected(formData);
    });

});

function makeAjaxRequestrejected(formData) {
    $.ajax({
        url: "/add-donation-rejected-data",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            $("#loader").hide();
            handleResponse(response);
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}
////Rjected Approval
