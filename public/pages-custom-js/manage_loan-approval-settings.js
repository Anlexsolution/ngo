
    $(document).ready(function () {
        // Open update modal and set values
        $(document).on("click", ".updateSetiingsModal", function () {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let min = $(this).data("minimum");
            let max = $(this).data("maximum");
            let count = $(this).data("count");

            $("#txtApprovalIdUpdate").val(id);
            $("#txtApprovalNameUpdate").val(name);
            $("#txtMinAmountUpdate").val(min);
            $("#txtMaxAmountUpdate").val(max);
            $("#txtHowManyApprovalUpdate").val(count);

            $("#updateApprovalModal").modal("show");
        });


    });


//Create Approval Ser
$('body').on('click', '#btnCreateApproval', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtApprovalName = $('#txtApprovalName').val();
   formData.append('txtApprovalName', txtApprovalName);

   var txtMinAmount = $('#txtMinAmount').val();
   formData.append('txtMinAmount', txtMinAmount);

   var txtMaxAmount = $('#txtMaxAmount').val();
   formData.append('txtMaxAmount', txtMaxAmount);

   var txtHowManyApproval = $('#txtHowManyApproval').val();
   formData.append('txtHowManyApproval', txtHowManyApproval);

   if(txtApprovalName == ''){
       $.alert({
           title: "Error!",
           content: "Please fill the approval name",
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

   if(txtMinAmount == ''){
    $.alert({
        title: "Error!",
        content: "Please fill themax amount",
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

if(txtMaxAmount == ''){
    $.alert({
        title: "Error!",
        content: "Please fill the min amount",
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

if(txtHowManyApproval == ''){
    $.alert({
        title: "Error!",
        content: "Please fill the how many approval",
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
       url: "/add-approval-settings-data",
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


//Update Approval Ser
$('body').on('click', '#btnUpdateApproval', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtApprovalIdUpdate = $('#txtApprovalIdUpdate').val();
   formData.append('txtApprovalIdUpdate', txtApprovalIdUpdate);

   var txtApprovalNameUpdate = $('#txtApprovalNameUpdate').val();
   formData.append('txtApprovalNameUpdate', txtApprovalNameUpdate);

   var txtMinAmountUpdate = $('#txtMinAmountUpdate').val();
   formData.append('txtMinAmountUpdate', txtMinAmountUpdate);

   var txtMaxAmountUpdate = $('#txtMaxAmountUpdate').val();
   formData.append('txtMaxAmountUpdate', txtMaxAmountUpdate);

      var txtHowManyApprovalUpdate = $('#txtHowManyApprovalUpdate').val();
   formData.append('txtHowManyApprovalUpdate', txtHowManyApprovalUpdate);

   if(txtApprovalNameUpdate == ''){
       $.alert({
           title: "Error!",
           content: "Please fill the approval name",
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

   if(txtMinAmountUpdate == ''){
    $.alert({
        title: "Error!",
        content: "Please fill themax amount",
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

if(txtMaxAmountUpdate == ''){
    $.alert({
        title: "Error!",
        content: "Please fill the min amount",
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

if(txtHowManyApprovalUpdate == ''){
    $.alert({
        title: "Error!",
        content: "Please fill the how many approval",
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
       url: "/update-approval-settings-data",
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
