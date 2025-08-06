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
$('body').on('click', '#btnCreateOldLoan', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSelectMember = $('#txtSelectMember').val();
   formData.append('txtSelectMember', txtSelectMember);

   var txtLoanId = $('#txtLoanId').val();
   formData.append('txtLoanId', txtLoanId);

   var txtLoanAmount = $('#txtLoanAmount').val();
   formData.append('txtLoanAmount', txtLoanAmount);

   var txtLoanTerm = $('#txtLoanTerm').val();
   formData.append('txtLoanTerm', txtLoanTerm);

   var txtRepaymentFrequency = $('#txtRepaymentFrequency').val();
   formData.append('txtRepaymentFrequency', txtRepaymentFrequency);

   var txtInterestRate = $('#txtInterestRate').val();
   formData.append('txtInterestRate', txtInterestRate);

   var txtRepaymentPreriod = $('#txtRepaymentPreriod').val();
   formData.append('txtRepaymentPreriod', txtRepaymentPreriod);

   var txtPer = $('#txtPer').val();
   formData.append('txtPer', txtPer);


   var txtLoanOfficer = $('#txtLoanOfficer').val();
   formData.append('txtLoanOfficer', txtLoanOfficer);

   var txtLoanPurpose = $('#txtLoanPurpose').val();
   formData.append('txtLoanPurpose', txtLoanPurpose);

      var txtLoanGuarantors = $('#txtLoanGuarantors').val();
   formData.append('txtLoanGuarantors', txtLoanGuarantors);

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

      var txtLoanDate = $('#txtLoanDate').val();
   formData.append('txtLoanDate', txtLoanDate);

      if(txtLoanDate == ''){
       $.alert({
           title: "Error!",
           content: "Please select the loan date",
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

   if(txtSelectMember == ''){
       $.alert({
           title: "Error!",
           content: "Please select member",
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
       makeAjaxRequestcreateOldLoan(formData);
   });

});

function makeAjaxRequestcreateOldLoan(formData) {
   $.ajax({
       url: "/create-old-loan-data",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       beforeSend: function () {
           $("#loader").show();
       },
       success: function (response) {
        handleResponse(response);
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
