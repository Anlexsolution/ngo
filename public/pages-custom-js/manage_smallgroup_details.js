$(document).ready(function(){
    $('.selectize').selectize();
});


////division create
$('body').on('click', '#btnUpdateSmallgroupDetails', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var smallGroupId = $('#smallGroupId').val();
   formData.append('smallGroupId', smallGroupId);

   var txtGroupLeader = $('#txtGroupLeader').val();
   formData.append('txtGroupLeader', txtGroupLeader);

   var txtSecretary = $('#txtSecretary').val();
   formData.append('txtSecretary', txtSecretary);

   

   if(txtGroupLeader == ''){
    $('#txtGroupLeader').focus();
       $.alert({
           title: "Error!",
           content: "Please select a smallgroup leader",
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

   

    // AJAX request
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/update-smallgroup-details",
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