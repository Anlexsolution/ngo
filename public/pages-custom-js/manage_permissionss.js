
// Update permission
$('body').on('click', '#btnUpdateUserPermission', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtUserId = $('#txtUserId').val();
   formData.append('txtUserId', txtUserId);

   const checkboxes = document.querySelectorAll('.userPermissions:checked');
   const selectedPermissions = Array.from(checkboxes).map(checkbox => checkbox.value);

   formData.append('selectedPermissions', JSON.stringify(selectedPermissions));

   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxRequest(formData);
   });

});

function makeAjaxRequest(formData) {
   $.ajax({
       url: "/update-user-permission-data",
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
// Update permission



