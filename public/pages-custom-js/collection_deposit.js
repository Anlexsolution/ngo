$(document).ready(function () {

});

//Collection Deposit
$('body').on('click', '#btnCreateDeposit', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txttotalDepositPending = $(this).attr('data-totaldeposit');
    formData.append('txttotalDepositPending', txttotalDepositPending);

    var txtDepositAmount = $('#txtDepositAmount').val();
    formData.append('txtDepositAmount', txtDepositAmount);

    var txtSlipNo = $('#txtSlipNo').val();
    formData.append('txtSlipNo', txtSlipNo);

    var txtGetbalanceDepositAm = $('#txtGetbalanceDepositAm').text();
   var numericValue = parseFloat(txtGetbalanceDepositAm.replace(/,/g, ''));


    if (txtDepositAmount == '') {
        $('#txtDepositAmount').focus();
        $.alert({
            title: "Error!",
            content: "Please fill the deposit Amount",
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

    if (txtDepositAmount > numericValue) {
        $('#txtDepositAmount').focus();
        $.alert({
            title: "Error!",
            content: "The remaining deposit amount is insufficient.",
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

    if (txtSlipNo == '') {
        $('#txtSlipNo').focus();
        $.alert({
            title: "Error!",
            content: "Please fill the slip number",
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
        makeAjaxRequestDeposit(formData);
    });

});

function makeAjaxRequestDeposit(formData) {
    $.ajax({
        url: "/insert-collection-deposit",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            handleResponse(response);
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}
//Collection Deposit
