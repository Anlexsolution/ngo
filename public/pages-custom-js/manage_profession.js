
//Create Profeesion
$('body').on('click', '#btnCreateProfession', function(){
     $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var modalProfessionName = $('#modalProfessionName').val();
    formData.append('modalProfessionName', modalProfessionName);

    if(modalProfessionName == ''){
        $.alert({
            title: "Error!",
            content: "Please fill the profession name",
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
        url: "/add-profession-data",
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


//Create Sub Profeesion
$('body').on('click', '#btnCreateSubProfession', function(){
     $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtSubProName = $('#txtSubProName').val();
    formData.append('txtSubProName', txtSubProName);

    var txtSubProfessionId = $('#txtSubProfessionId').val();
    formData.append('txtSubProfessionId', txtSubProfessionId);

    if(txtSubProName == ''){
        $.alert({
            title: "Error!",
            content: "Please fill the Sub profession name",
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
        makeAjaxRequestSubPro(formData);
    });

});

function makeAjaxRequestSubPro(formData) {
    $.ajax({
        url: "/add-sub-profession-data",
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
////Create Sub Profeesion

//open update modal
$('body').on('click', '.btnUpdateProfession', function(){
    var professName = $(this).attr('data-name');
    var proId = $(this).attr('data-id');
    $('#txtProfessionId').val(proId);
    $('#txtproName').val(professName);
    $('#updateProfessionModal').modal('show');
});
//open update modal

//open update modal
$('body').on('click', '.btnSubProModalView', function(){
    var proId = $(this).attr('data-id');
    $('#txtSubProfessionId').val(proId);
    $('#addSubProfessionModal').modal('show');
});
//open update modal



//Update Profeesion
$('body').on('click', '#btnUpdateProfession', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtProfessionId = $('#txtProfessionId').val();
   formData.append('txtProfessionId', txtProfessionId);

   var txtproName = $('#txtproName').val();
   formData.append('txtproName', txtproName);

   if(txtproName == ''){
       $.alert({
           title: "Error!",
           content: "Please fill the profession name",
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
       url: "/update-profession-data",
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
