// Create User Role
$('body').on('click', '#btnCreateUserRole', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var roleName = $('#roleName').val();
   formData.append('roleName', roleName);

   const checkboxes = document.querySelectorAll('.userPermissions:checked');
   const selectedPermissions = Array.from(checkboxes).map(checkbox => checkbox.value);

   formData.append('selectedPermissions', JSON.stringify(selectedPermissions));

   if(roleName == ''){
    $.alert({
        title: "Error!",
        content: "Please fill the role name",
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
       makeAjaxRequestCreateUserRole(formData);
   });

});

function makeAjaxRequestCreateUserRole(formData) {
   $.ajax({
       url: "/create-user-role-data",
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
// Create User Role