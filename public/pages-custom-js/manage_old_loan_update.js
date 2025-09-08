$(document).ready(function(){
    $('.selectize').selectize();
    $('#txtLoanGuarantors').selectize({
        maxItems: null,
    });
});


$('body').on('change', '#txtSelectMember', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSelectMember = $('#txtSelectMember').val();
   formData.append('txtSelectMember', txtSelectMember);

   if(txtSelectMember == ''){
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
       makeAjaxRequestAmount(formData);
   });

});

function makeAjaxRequestAmount(formData) {
   $.ajax({
       url: "/get-old-loan-gurantos-data",
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
            $("#txtLoanGuarantors")[0].selectize.destroy();
            $("#txtLoanGuarantors").empty();
            $("#txtLoanGuarantors").append(response.selectGurantos);
            $('#txtLoanGuarantors').selectize({
                maxItems: null,
            });
            $("#loader").hide();
           }else{
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


//Create Loan
$('body').on('click', '#btnUpdateOldLoan', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

      var txtLoanGuarantors = $('#txtLoanGuarantors').val();
   formData.append('txtLoanGuarantors', txtLoanGuarantors);

         var txtLoanType = $('#txtLoanType').val();
   formData.append('txtLoanType', txtLoanType);

            var txtLoanIdUpdate = $('#txtLoanIdUpdate').val();
   formData.append('txtLoanIdUpdate', txtLoanIdUpdate);

   var txtFollowerName = $('#txtFollowerName').val();
   formData.append('txtFollowerName', txtFollowerName);

   var txtFollowerAddress = $('#txtFollowerAddress').val();
   formData.append('txtFollowerAddress', txtFollowerAddress);

   var txtFollowerNic = $('#txtFollowerNic').val();
   formData.append('txtFollowerNic', txtFollowerNic);

   var txtFollowerNicIssueDate = $('#txtFollowerNicIssueDate').val();
   formData.append('txtFollowerNicIssueDate', txtFollowerNicIssueDate);

   var txtFollowerPhoneNumber = $('#txtFollowerPhoneNumber').val();
   formData.append('txtFollowerPhoneNumber', txtFollowerPhoneNumber);

   var txtFollowerProfession = $('#txtFollowerProfession').val();
   formData.append('txtFollowerProfession', txtFollowerProfession);



   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxRequestcreateOldLoan(formData);
   });

});

function makeAjaxRequestcreateOldLoan(formData) {
   $.ajax({
       url: "/update-old-loan-data",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       beforeSend: function () {
           $("#loader").show();
       },
       success: function (response) {
              $.alert({
            title: 'Success',
            content: response.success,
            type: "green",
            icon: "fa fa-check-circle",
            theme: 'modern',
            buttons: {
                okay: {
                    text: "Okay",
                    btnClass: "btn-green",
                    action: function() {
                        location.href = '/list_of_loan';
                        $("#page-loader").hide();
                    },
                },
            },
        });
           $("#loader").hide();

       },
       error: function (xhr, status, error) {
           $("#loader").hide();
           console.error("Error:", error);
           showAlert("Error!", "Something went wrong!");
       },
   });
}
////Create Loan
