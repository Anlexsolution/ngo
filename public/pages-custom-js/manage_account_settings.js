$(document).ready(function(){
    $('.selectize').selectize();
});

//Create Account
$('body').on('click', '#btnUpdateAccount', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSelectCollectionAccount = $('#txtSelectCollectionAccount').val();
   formData.append('txtSelectCollectionAccount', txtSelectCollectionAccount);

   if(txtSelectCollectionAccount == ''){
       $.alert({
           title: "Error!",
           content: "Please select the collection account",
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
       url: "/update-account-details",
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