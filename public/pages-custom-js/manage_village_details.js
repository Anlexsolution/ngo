$(document).ready(function(){
    $('.selectize').selectize();
});


////division create
$('body').on('click', '#btnUpdateVillageDetails', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var villageId = $('#villageId').val();
   formData.append('villageId', villageId);

   var txtVillageLeader = $('#txtVillageLeader').val();
   formData.append('txtVillageLeader', txtVillageLeader);

   var txtSecretary = $('#txtSecretary').val();
   formData.append('txtSecretary', txtSecretary);

   var txtFoName = $('#txtFoName').val();
   formData.append('txtFoName', txtFoName);

   var txtPhoneNumber = $('#txtPhoneNumber').val();
   formData.append('txtPhoneNumber', txtPhoneNumber);

   var txtStaff = $('#txtStaff').val();
   formData.append('txtStaff', JSON.stringify(txtStaff));

   if(txtVillageLeader == ''){
    $('#txtVillageLeader').focus();
       $.alert({
           title: "Error!",
           content: "Please select a village leader",
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

   if(txtSecretary == ''){
    $('#txtSecretary').focus();
       $.alert({
           title: "Error!",
           content: "Please select a Secretary",
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

   if(txtStaff == ''){
    $('#txtStaff').focus();
       $.alert({
           title: "Error!",
           content: "Please select a Staff",
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
           content: "Please select a FO name",
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

    // AJAX request
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/update-village-details",
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