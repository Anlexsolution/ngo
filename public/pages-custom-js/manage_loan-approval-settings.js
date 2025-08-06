
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

$('body').on('click', '.updateSetiingsModal', function(){
    $("#loader").show();
    var appId =  $(this).attr('data-id');
    var appName =  $(this).attr('data-name');
    var appMinAmount =  $(this).attr('data-minimum');
    var appMaxAmount =  $(this).attr('data-maximum');
    var appHowManyApproval =  $(this).attr('data-count');

});
