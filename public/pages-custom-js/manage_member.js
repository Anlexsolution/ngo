$(document).ready(function() {
    $('.selectize').selectize();
    $('#memberTable').DataTable({
        responsive: true
    });
})

//Create Profeesion
$('body').on('click', '#btnImportMember', function(){
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
       makeAjaxRequest(formData);
   });

});

function makeAjaxRequest(formData) {
   $.ajax({
       url: "/import-member-data",
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
////Create Profeesion

$('body').on('click', '.btnshowStatusModal', function(){
    var id = $(this).attr('data-id');
    $('#txtMemberId').val(id);
    $('#changeStatusModal').modal('show');
});

$('body').on('change', '#txtStatus', function(){
    var status = $(this).val();
    if(status == 1){
        document.getElementById("txtStatusTypeDiv").hidden = false;
    }else{
      document.getElementById("txtStatusTypeDiv").hidden = true;
    }
});


// Update Member Status
$('body').on('click', '#btnChangeStatusMember', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtMemberId = $('#txtMemberId').val();
   formData.append('txtMemberId', txtMemberId);

      var txtStatusType = $('#txtStatusType').val();
   formData.append('txtStatusType', txtStatusType);

      var txtStatus = $('#txtStatus').val();
   formData.append('txtStatus', txtStatus);


   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxRequestChangeStatus(formData);
   });

});

function makeAjaxRequestChangeStatus(formData) {
   $.ajax({
       url: "/create-member-status-data",
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
// Update Member Status