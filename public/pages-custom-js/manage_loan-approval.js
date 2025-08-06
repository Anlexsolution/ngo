$(document).ready(function(){
    $('.selectize').selectize();
});
//Create loan approval
$('body').on('click', '#btnAprovalLoan', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var loanId = $('#txtLoanIdGetApproval').val();
    formData.append('loanId', loanId);

    var txtApprovalReason = $('#txtApprovalReason').val();
    formData.append('txtApprovalReason', txtApprovalReason);

    var appStatus = 'approved';
    formData.append('approvalStatus', appStatus);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/add-loan-approval-data",
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
//Create loan approval


//Create loan approval - final
$('body').on('click', '#btnAprovalLoanFinal', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var loanId = $('#txtLoanIdGetApprovalFinal').val();
    formData.append('loanId', loanId);

    var txtApprovalReason = $('#txtApprovalReasonFinal').val();
    formData.append('txtApprovalReason', txtApprovalReason);

    var txtAccount = $('#txtAccount').val();
    formData.append('txtAccount', txtAccount);

    var txtCheckNoFinal = $('#txtCheckNoFinal').val();
    formData.append('txtCheckNoFinal', txtCheckNoFinal);

    var appStatus = 'approved';
    formData.append('approvalStatus', appStatus);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/add-loan-approval-data",
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
//Create loan approval

$('body').on('click', '.btnAprovalLoanModal', function () {
    var loanId = $(this).attr('data-id');
    $('#txtLoanIdGetApproval').val(loanId);
    $('#btnAprovalLoanModal').modal('show');
})

$('body').on('click', '.btnAprovalLoanFinalModal', function () {
    var loanId = $(this).attr('data-id');
    $('#txtLoanIdGetApprovalFinal').val(loanId);
    $('#btnAprovalLoanModalFinal').modal('show');
})

$('body').on('click', '.btnRejectLoanModal', function () {
    var loanId = $(this).attr('data-id');
    $('#txtLoanIdGetRejected').val(loanId);
    $('#btnRejectLoanModals').modal('show');
})


//Create loan approval
$('body').on('click', '#btnRelectLoan', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var loanId = $('#txtLoanIdGetRejected').val();
    formData.append('loanId', loanId);

    var txtApprovalReason = $('#btnRelectLoan').val();
    formData.append('txtApprovalReason', txtApprovalReason);

    var appStatus = 'Rejected';
    formData.append('approvalStatus', appStatus);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/add-loan-approval-data",
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
//Create loan approval
