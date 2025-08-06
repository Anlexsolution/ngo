$(document).ready(function(){
    $('.selectize').selectize();
});

$('body').on('click', '#CreateFInalLoan', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtLoanId = $('#txtLoanId').val();
   formData.append('txtLoanId', txtLoanId);

   var txtName = $('#txtName').val();
   formData.append('txtName', txtName);

   var txtAddress = $('#txtAddress').val();
   formData.append('txtAddress', txtAddress);

   var txtNic = $('#txtNic').val();
   formData.append('txtNic', txtNic);

   var txtNicIssueDate = $('#txtNicIssueDate').val();
   formData.append('txtNicIssueDate', txtNicIssueDate);

   var txtPhoneNumber = $('#txtPhoneNumber').val();
   formData.append('txtPhoneNumber', txtPhoneNumber);

   var txtProfession = $('#txtProfession').val();
   formData.append('txtProfession', txtProfession);

   if(txtName == ''){
       $.alert({
           title: "Error!",
           content: "Please fill the name",
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
       makeAjaxRequestPurpose(formData);
   });

});

function makeAjaxRequestPurpose(formData) {
   $.ajax({
       url: "/create-new-loan",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       beforeSend: function () {
           $("#loader").show();
       },
       success: function (response) {
           $("#loader").hide();
           if(response.code == 200){
            $.alert({
                title: 'Success',
                content: 'Loan created successfully!',
                type: "green",
                theme: 'modern',
                buttons: {
                    okay: {
                        text: "Okay",
                        btnClass: "btn-green",
                        action: function () {
                            location.href="/list_of_loan"
                            $("#loader").hide();
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