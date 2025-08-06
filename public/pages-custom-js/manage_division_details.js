$(document).ready(function(){
    $('.selectize').selectize();
});


////division create
$('body').on('click', '#btnUpdateDivisionDetails', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var divisionId = $('#divisionId').val();
   formData.append('divisionId', divisionId);

   var txtDivisionHead = $('#txtDivisionHead').val();
   formData.append('txtDivisionHead', txtDivisionHead);

   var txtDMName = $('#txtDMName').val();
   formData.append('txtDMName', txtDMName);

   var txtRCName = $('#txtRCName').val();
   formData.append('txtRCName', txtRCName);

   var txtPhoneNumber = $('#txtPhoneNumber').val();
   formData.append('txtPhoneNumber', txtPhoneNumber);

   var txtAddress = $('#txtAddress').val();
   formData.append('txtAddress', txtAddress);

   var txtFoName = $('#txtFoName').val();
   formData.append('txtFoName', JSON.stringify(txtFoName));

   if(txtDivisionHead == ''){
    $('#txtDivisionHead').focus();
       $.alert({
           title: "Error!",
           content: "Please select a division head",
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

   if(txtDMName == ''){
    $('#txtDMName').focus();
       $.alert({
           title: "Error!",
           content: "Please select a DM",
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

   if(txtRCName == ''){
    $('#txtRCName').focus();
       $.alert({
           title: "Error!",
           content: "Please select a RC",
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

   if( txtFoName == ''){
    $('#txtFoName').focus();
       $.alert({
           title: "Error!",
           content: "Please select a FO",
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

   if(txtPhoneNumber == ''){
    $('#txtPhoneNumber').focus();
       $.alert({
           title: "Error!",
           content: "Please enter the phone number",
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

   if( txtAddress == ''){
    $('#txtAddress').focus();
       $.alert({
           title: "Error!",
           content: "Please enter a address",
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

    // AJAX request
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/update-division-details",
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
////division create