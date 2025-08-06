$(document).ready(function(){
    $('.selectize').selectize();
})


$('body').on('click', '#viewTransfer', function(){
    var transferName = $(this).attr('data-name');
    var transAm = $(this).attr('data-amount');
    var remark = $(this).attr('data-remarks');
    $('#transferAcc').text(transferName);
     $('#transferAM').text(transAm);
      $('#transferRemark').text(remark);
    $('#viewTransferModal').modal('show');
})

//Create Account
$('body').on('click', '#btnCreateAccount', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtAccountName = $('#txtAccountName').val();
   formData.append('txtAccountName', txtAccountName);

   var txtBranchName = $('#txtBranchName').val();
   formData.append('txtBranchName', txtBranchName);

   var txtAccountNumber = $('#txtAccountNumber').val();
   formData.append('txtAccountNumber', txtAccountNumber);

   var txtRegisterDate = $('#txtRegisterDate').val();
   formData.append('txtRegisterDate', txtRegisterDate);

   var txtAccountType = $('#txtAccountType').val();
   formData.append('txtAccountType', txtAccountType);

    var txtStatus = $('#txtStatus').val();
   formData.append('txtStatus', txtStatus);

   var txtNote = $('#txtNote').val();
   formData.append('txtNote', txtNote);

   var txtOpeningBalance = $('#txtOpeningBalance').val();
   formData.append('txtOpeningBalance', txtOpeningBalance);

   if(txtAccountName == ''){
       $.alert({
           title: "Error!",
           content: "Please fill the account name",
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

   if(txtBranchName == ''){
    $.alert({
        title: "Error!",
        content: "Please fill the branch name",
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

if(txtAccountNumber == ''){
    $.alert({
        title: "Error!",
        content: "Please fill the account number",
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

if(txtRegisterDate == ''){
    $.alert({
        title: "Error!",
        content: "Please select the register date",
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

if(txtStatus == ''){
    $.alert({
        title: "Error!",
        content: "Please select the status",
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

   if(txtAccountType == ''){
       $.alert({
           title: "Error!",
           content: "Please select the account type",
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

if(txtOpeningBalance == ''){
    $.alert({
        title: "Error!",
        content: "Please fill the opening balance",
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
       createAccount(formData);
   });

});

function createAccount(formData) {
   $.ajax({
       url: "/add-account-data",
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
////Create Account



//Transfer Account
$('body').on('click', '#btnCreateTransfer', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtFromAccount = $('#txtFromAccount').val();
   formData.append('txtFromAccount', txtFromAccount);

   var txtToAccount = $('#txtToAccount').val();
   formData.append('txtToAccount', txtToAccount);

   var txtTransferAmount = $('#txtTransferAmount').val();
   formData.append('txtTransferAmount', txtTransferAmount);

      var txtRemarks = $('#txtRemarks').val();
   formData.append('txtRemarks', txtRemarks);

   if(txtFromAccount == ''){
       $.alert({
           title: "Error!",
           content: "Please select from account",
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


if(txtToAccount == ''){
    $.alert({
        title: "Error!",
        content: "Please select to account",
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

if(txtTransferAmount == ''){
    $.alert({
        title: "Error!",
        content: "Please enter the transfer amount",
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
       transferAccount(formData);
   });

});

function transferAccount(formData) {
   $.ajax({
       url: "/transfer-account-data",
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
////Create Account


////Create Expensive / Income
$('body').on('click', '#btnCreateExpensiveIncome', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSelectAccount = $('#txtSelectAccount').val();
   formData.append('txtSelectAccount', txtSelectAccount);

   var txtType = $('#txtType').val();
   formData.append('txtType', txtType);

   var txtDate = $('#txtDate').val();
   formData.append('txtDate', txtDate);

   var txtAmount = $('#txtAmount').val();
   formData.append('txtAmount', txtAmount);

   var txtExpensiveRemarks = $('#txtExpensiveRemarks').val();
   formData.append('txtExpensiveRemarks', txtExpensiveRemarks);

   if(txtSelectAccount == ''){
       $.alert({
           title: "Error!",
           content: "Please select account",
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

   if(txtType == ''){
    $.alert({
        title: "Error!",
        content: "Please select type",
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

if(txtDate == ''){
    $.alert({
        title: "Error!",
        content: "Please select the date",
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

if(txtAmount == ''){
    $.alert({
        title: "Error!",
        content: "Please enter the amount",
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
   if(txtExpensiveRemarks == ''){
       $.alert({
           title: "Error!",
           content: "Please enter remaarks",
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
       createExpensiveIncome(formData);
   });

});

function createExpensiveIncome(formData) {
   $.ajax({
       url: "/add-expensive-income-data",
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
////Create Expensive / Income
