
//Create Profeesion
$('body').on('click', '#btnCreateMeetingType', function(){
     $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMeetingTypeName = $('#txtMeetingTypeName').val();
    formData.append('txtMeetingTypeName', txtMeetingTypeName);

    if(txtMeetingTypeName == ''){
        $.alert({
            title: "Error!",
            content: "Please fill the meeting category name",
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
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/add-meeting-category-data",
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

//open update modal
$('body').on('click', '.btnUpdateMeetingType', function(){
    var professName = $(this).attr('data-name');
    var proId = $(this).attr('data-id');
    $('#txtMeetingTypeId').val(proId);
    $('#txtMeetingTypeNameUpdate').val(professName);
    $('#updateMeetingTypeModal').modal('show');
});
//open update modal



//Update Profeesion
$('body').on('click', '#btnUpdateMeetingType', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtMeetingTypeId = $('#txtMeetingTypeId').val();
   formData.append('txtMeetingTypeId', txtMeetingTypeId);

   var txtMeetingTypeNameUpdate = $('#txtMeetingTypeNameUpdate').val();
   formData.append('txtMeetingTypeNameUpdate', txtMeetingTypeNameUpdate);

   if(txtMeetingTypeNameUpdate == ''){
       $.alert({
           title: "Error!",
           content: "Please fill the meeting type name",
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
       makeAjaxRequestUpdate(formData);
   });

});

function makeAjaxRequestUpdate(formData) {
   $.ajax({
       url: "/update-meeting-category-data",
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
////Update Profeesion


//open delete modal
$('body').on('click', '.btnDeletePro', function(){
    var proId = $(this).attr('data-id');
    $('#txtProId').val(proId);
    $('#proDeleteModal').modal('show');
});
//open delete modal

//Delete Profeesion
$('body').on('click', '#confirmDeleteProBtn', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtProId = $('#txtProId').val();
   formData.append('txtProId', txtProId);


   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxRequestDelete(formData);
   });

});

function makeAjaxRequestDelete(formData) {
   $.ajax({
       url: "/delete-profession-data",
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
////Delete Profeesion
