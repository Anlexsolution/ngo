$(document).ready(function(){
    $('.selectize').selectize();
    $('#txtSavingAccount').selectize();
});

//GET DATA
$('body').on('change', '#txtMember', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtMember = $('#txtMember').val();
   formData.append('txtMember', txtMember);

   console.log(txtMember);

   if(txtMember == ''){
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
        url: "/get-member-saving-account-data",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            var data = response.accountData;
            let selectize = $('#txtSavingAccount')[0].selectize;
            
            // Clear existing options
            selectize.clear();
            selectize.clearOptions();
            
            // Check the format of the data
            if (typeof data === 'string') {
                // If the server returns HTML string (which seems to be the case)
                // Parse the HTML string to extract options
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data;
                const options = tempDiv.querySelectorAll('option');
                
                // Add each option to selectize
                options.forEach(option => {
                    selectize.addOption({
                        value: option.value,
                        text: option.textContent
                    });
                });
            } else if (Array.isArray(data)) {
                // If data is an array of objects
                data.forEach(function(item) {
                    selectize.addOption({
                        value: item.id || item.value,
                        text: item.text || item.name
                    });
                });
            }
            
            // Refresh the options
            selectize.refreshOptions(true);
            
            document.getElementById('txtGetAccDiv').hidden = false;
            $("#loader").hide();
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}
//GET DATA


////Create Withrawal 
$('body').on('click', '#btnWithdrawalRequest', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtMember = $('#txtMember').val();
   formData.append('txtMember', txtMember);

   if(txtMember == ''){
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

   var txtSavingAccount = $('#txtSavingAccount').val();
   formData.append('txtSavingAccount', txtSavingAccount);

   if(txtSavingAccount == ''){
       $.alert({
           title: "Error!",
           content: "Please select the saving account",
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

   var txtAmount = $('#txtAmount').val();
   formData.append('txtAmount', txtAmount);

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

   var txtApproveUser = $('#txtApproveUser').val();
   formData.append('txtApproveUser', txtApproveUser);

   if(txtApproveUser == ''){
       $.alert({
           title: "Error!",
           content: "Please select the approve user",
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

   var txtReason = $('#txtReason').val();
   formData.append('txtReason', txtReason);

   if(txtReason == ''){
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
       makeAjaxRequestWithdrawal(formData);
   });

});

function makeAjaxRequestWithdrawal(formData) {
   $.ajax({
       url: "/create-withdrawal-data",
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
////Create Withrawal 