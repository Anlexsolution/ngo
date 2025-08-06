$(document).ready(function(){
    $("#loader").show();
    $('.selectize').selectize();
    $("#loader").hide();
});

////First Approve
$('body').on('click', '#btnApproveFirst', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtReasonFirst = $('#txtReasonFirst').val();
   formData.append('txtReasonFirst', txtReasonFirst);

   var txtSecondApproveUserType = $('#txtSecondApproveUserType').val();
   formData.append('txtSecondApproveUserType', txtSecondApproveUserType);

   var txtApproveStatusFirst = $('#txtApproveStatusFirst').val();
   formData.append('txtApproveStatusFirst', txtApproveStatusFirst);

   var txtWithId = $('#txtWithId').val();
   formData.append('txtWithId', txtWithId);

   console.log(txtWithId);



   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxfirstRequest(formData);
   });

});

function makeAjaxfirstRequest(formData) {
   $.ajax({
       url: "/add-first-approve-data",
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
////First Approve


////Second Approve
$('body').on('click', '#btnApproveSecond', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtReasonSecond = $('#txtReasonSecond').val();
   formData.append('txtReasonSecond', txtReasonSecond);

   var txtThirdApproveUserType = $('#txtThirdApproveUserType').val();
   formData.append('txtThirdApproveUserType', txtThirdApproveUserType);

   var txtApproveStatusSecond = $('#txtApproveStatusSecond').val();
   formData.append('txtApproveStatusSecond', txtApproveStatusSecond);

   var txtWithId = $('#txtWithId').val();
   formData.append('txtWithId', txtWithId);



   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxsecondRequest(formData);
   });

});

function makeAjaxsecondRequest(formData) {
   $.ajax({
       url: "/add-second-approve-data",
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
////Second Approve


////Third Approve
$('body').on('click', '#btnApproveThird', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtReasonThird = $('#txtReasonThird').val();
   formData.append('txtReasonThird', txtReasonThird);

   var txtForthApproveUserType = $('#txtForthApproveUserType').val();
   formData.append('txtForthApproveUserType', txtForthApproveUserType);

   var txtApproveStatusThird = $('#txtApproveStatusThird').val();
   formData.append('txtApproveStatusThird', txtApproveStatusThird);

   var txtWithId = $('#txtWithId').val();
   formData.append('txtWithId', txtWithId);



   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxthirdRequest(formData);
   });

});

function makeAjaxthirdRequest(formData) {
   $.ajax({
       url: "/add-third-approve-data",
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
////Third Approve


////Forth Approve
$('body').on('click', '#btnApproveForth', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtReasonForth = $('#txtReasonForth').val();
   formData.append('txtReasonForth', txtReasonForth);

   var txtWithAccount = $('#txtWithAccount').val();
   formData.append('txtWithAccount', txtWithAccount);

   var txtApproveStatusForth = $('#txtApproveStatusForth').val();
   formData.append('txtApproveStatusForth', txtApproveStatusForth);

   var txtWithId = $('#txtWithId').val();
   formData.append('txtWithId', txtWithId);


   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxforthRequest(formData);
   });

});

function makeAjaxforthRequest(formData) {
   $.ajax({
       url: "/add-forth-approve-data",
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
////Forth Approve