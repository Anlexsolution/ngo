$(document).ready(function () {
    $('.selectize').selectize();
    $('#txtLoan').selectize();
});

$('body').on('change', '#txtMember', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMember = $('#txtMember').val();
    formData.append('txtMember', txtMember);
    if (txtMember == '') {
        $.alert({
            title: "Error!",
            content: "Please select the member",
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
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/get-member-loan-data",
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
                $("#txtLoan")[0].selectize.destroy();
                $("#txtLoan").empty();
                $("#txtLoan").append(response.getAllLoanOption);
                $("#txtLoan").selectize();
                $("#loader").hide();
            } else {
                $.alert({
                    title: "Alert",
                    content: "Something went wrong",
                    icon: "fa fa-exclamation-triangle",
                    type: "red",
                    theme: "modern",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-red",
                            action: function () {
                                $("#page-loader").hide();
                            },
                        },
                    },
                });
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}


$('body').on('click', '#btnAddLoandata', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtLoan = $('#txtLoan').val();
    formData.append('txtLoan', txtLoan);

    var txtPaymentDate = $('#txtPaymentDate').val();
    formData.append('txtPaymentDate', txtPaymentDate);

    console.log(txtPaymentDate);

    if (txtLoan == '') {
        $.alert({
            title: "Error!",
            content: "Please select the loan",
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
        makeAjaxRequestLoanGet(formData);
    });

});

function makeAjaxRequestLoanGet(formData) {
    $.ajax({
        url: "/get-loan-repayment-data",
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

                let formattedInterest = new Intl.NumberFormat('en-US', {
                    style: 'decimal',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(response.interest);

                let formattedprincipalPayment = new Intl.NumberFormat('en-US', {
                    style: 'decimal',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(response.principalPayment);

                let formattedtotalPay = new Intl.NumberFormat('en-US', {
                    style: 'decimal',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(response.totalPay);

                let formattedloanAmount = new Intl.NumberFormat('en-US', {
                    style: 'decimal',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(response.loanAmount);

                let formattedbalancePay = new Intl.NumberFormat('en-US', {
                    style: 'decimal',
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                }).format(response.balancePay);

   if (parseFloat(response.balancePay) < 0) {
            return;
        }

        let loanCounter = 1;
        const row = `
        <tr>
            <td>${loanCounter++}</td>
            <td class='loan-id'>${response.loanId}</td>
            <td class='loan-amount'>${formattedloanAmount}</td>
            <td class='days'>${response.days}</td>
            <td class='interest'>${formattedInterest}</td>
            <td class='principal'>${formattedprincipalPayment}</td>
            <td class='total'>${formattedtotalPay}</td>
            <td class='balance'>${formattedbalancePay}</td>
            <td><input type="number" class="form-control pay-amount" id="txtPayAmount"></td>
        </tr>
        `;

        $('#tblLoanRepayment tbody').append(row);
                $("#loader").hide();
            } else if(response.code === 202){
                $.alert({
                    title: "Alert",
                    content: response.message,
                    icon: "fa fa-exclamation-triangle",
                    type: "red",
                    theme: "modern",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-red",
                            action: function () {
                                $("#page-loader").hide();
                            },
                        },
                    },
                });
            }
            else{
                $.alert({
                    title: "Alert",
                    content: "Something went wrong",
                    icon: "fa fa-exclamation-triangle",
                    type: "red",
                    theme: "modern",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-red",
                            action: function () {
                                $("#page-loader").hide();
                            },
                        },
                    },
                });
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}



//Payment Data
$('body').on('click', '#txtRepaymentAmount', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMember = $('#txtMember').val();
    formData.append('txtMember', txtMember);

    var txtLoan = $('#txtLoan').val();
    formData.append('txtLoan', txtLoan);

    var txtPaymentDate = $('#txtPaymentDate').val();
    formData.append('txtPaymentDate', txtPaymentDate);

    var txtSavingAmount = $('#txtSavingAmount').val();
    formData.append('txtSavingAmount', txtSavingAmount);

    let loanData = [];

    $('#tblLoanRepayment tbody tr').each(function () {
  const loanId = $(this).find('.loan-id').text().trim();
    const loanAmount = parseFloat($(this).find('.loan-amount').text().replace(/,/g, ''));
    const days = parseInt($(this).find('.days').text().trim(), 10);
    const interest = parseFloat($(this).find('.interest').text().replace(/,/g, ''));
    const principal = parseFloat($(this).find('.principal').text().replace(/,/g, ''));
    const total = parseFloat($(this).find('.total').text().replace(/,/g, ''));
    const balance = parseFloat($(this).find('.balance').text().replace(/,/g, ''));
    const payAmount = parseFloat($(this).find('.pay-amount').val().replace(/,/g, ''));

        loanData.push({
            loanId,
            loanAmount,
            days,
            interest,
            principal,
            total,
            balance,
            payAmount
        });
    });

    console.log(loanData);
    formData.append('loanData', JSON.stringify(loanData));

    if (loanData.length === 0 && (!txtSavingAmount || parseFloat(txtSavingAmount) <= 0)) {
        $.alert({
            title: "Error!",
            content: "Please enter a saving amount or add at least one loan to repay.",
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
    if (txtMember == '') {
        $.alert({
            title: "Error!",
            content: "Please select the member",
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

    // if (txtLoan == '') {
    //     $.alert({
    //         title: "Error!",
    //         content: "Please select the loan",
    //         type: "red",
    //         theme: 'modern',
    //         buttons: {
    //             okay: {
    //                 text: "Okay",
    //                 btnClass: "btn-red",
    //                 action: function () {
    //                     $("#loader").hide();
    //                 },
    //             },
    //         },
    //     });
    //     return false;
    // }

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestRepayment(formData);
    });

});

function makeAjaxRequestRepayment(formData) {
    $.ajax({
        url: "/pay-repayment-data",
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
//Payment Data


////Create Import
$('body').on('click', '#btnImportRepayment', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    let fileInput = document.getElementById('txtImportFile');
    let file = fileInput.files[0];

    if (!file) {
        $.alert({
            title: "Error!",
            content: "Please Select the file",
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
    formData.append("file", file);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestImport(formData);
    });

});

function makeAjaxRequestImport(formData) {
    $.ajax({
        url: "/import-repayment-data",
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
////Create Import
