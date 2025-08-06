$(document).ready(function(){
    $('.selectize').selectize();
});

////User create
$('body').on('click', '#btnCreateUser', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtFullName = $('#txtFullName').val();
   formData.append('txtFullName', txtFullName);

   var userName = $('#userName').val();
   formData.append('userName', userName);

   var email = $('#email').val();
   formData.append('email', email);

   var txtNic = $('#txtNic').val();
   formData.append('txtNic', txtNic);

   var txtPhoneNumber = $('#txtPhoneNumber').val();
   formData.append('txtPhoneNumber', txtPhoneNumber);

   var txtDOB = $('#txtDOB').val();
   formData.append('txtDOB', txtDOB);

   var txtProfessional = $('#txtProfessional').val();
   formData.append('txtProfessional', txtProfessional);

   var txtEpfNo = $('#txtEpfNo').val();
   formData.append('txtEpfNo', txtEpfNo);

   var txtGender = $('#txtGender').val();
   formData.append('txtGender', txtGender);

   var password = $('#password').val();
   formData.append('password', password);

   var confirmPassword = $('#confirmPassword').val();
   formData.append('confirmPassword', confirmPassword);

   var userType = $('#userType').val();
   formData.append('userType', userType);

   if(password != confirmPassword){
    $('#password').focus();
       $.alert({
           title: "Error!",
           content: "Password not match try again",
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

   if(email == ''){
    $('#email').focus();
       $.alert({
           title: "Error!",
           content: "Please fill the email",
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

   if(txtFullName == ''){
    $('#txtFullName').focus();
       $.alert({
           title: "Error!",
           content: "Please fill the full name",
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
    $.ajax({
       url: "/createusers",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       beforeSend: function () {
           $("#loader").show();
       },
       success: function (response) {
           $("#loader").hide();
           if (response.code == 200) {
               $.alert({
                   title: "Success!",
                   content: "User Created successfully!",
                   type: "green",
                   theme: 'modern',
                   buttons: {
                       okay: {
                           text: "Okay",
                           btnClass: "btn-green",
                           action: function () {
                               location.reload();
                           },
                       },
                   },
               });
           } else if (response.code == 403) {
               $.alert({
                   title: "Error!",
                   content: "CSRF Error Try Again",
                   type: "red",
                   theme:'modern',
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
           }else if (response.code == 500) {
            $.alert({
                title: "Error!",
                content: response.error,
                type: "red",
                theme:'modern',
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
        } else {
               $.alert({
                   title: "Error!",
                   content: "Something went wrong!",
                   type: "red",
                   theme:'modern',
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
           }
       },
       error: function (xhr, status, error) {
           $("#loader").hide();
           console.error("Error:", error);
           $.alert({
               title: "Error!",
               content: "Something went wrong!",
               type: "red",
               buttons: {
                   okay: {
                       text: "Okay",
                       btnClass: "btn-red",
                       action: function () {
                           $("#loader").hide();
                           location.reload();
                       },
                   },
               },
           });
       },
   });

});
////User create


////User update
$('body').on('click', '#btnUpdateUser', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtFullName = $('#txtFullName').val();
   formData.append('txtFullName', txtFullName);

   var userName = $('#userName').val();
   formData.append('userName', userName);

   var email = $('#email').val();
   formData.append('email', email);

   var txtNic = $('#txtNic').val();
   formData.append('txtNic', txtNic);

   var txtPhoneNumber = $('#txtPhoneNumber').val();
   formData.append('txtPhoneNumber', txtPhoneNumber);

   var txtDOB = $('#txtDOB').val();
   formData.append('txtDOB', txtDOB);

   var txtProfessional = $('#txtProfessional').val();
   formData.append('txtProfessional', txtProfessional);

   var txtEpfNo = $('#txtEpfNo').val();
   formData.append('txtEpfNo', txtEpfNo);

   var txtGender = $('#txtGender').val();
   formData.append('txtGender', txtGender);

   var userType = $('#userType').val();
   formData.append('userType', userType);

   var txtUserId = $('#txtUserId').val();
   formData.append('txtUserId', txtUserId);

   if(email == ''){
    $('#email').focus();
       $.alert({
           title: "Error!",
           content: "Please fill the email",
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

   if(txtFullName == ''){
    $('#txtFullName').focus();
       $.alert({
           title: "Error!",
           content: "Please fill the full name",
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
    $.ajax({
       url: "/updateusers",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       beforeSend: function () {
           $("#loader").show();
       },
       success: function (response) {
           $("#loader").hide();
           if (response.code == 200) {
               $.alert({
                   title: "Success!",
                   content: "User Updated successfully!",
                   type: "green",
                   theme: 'modern',
                   buttons: {
                       okay: {
                           text: "Okay",
                           btnClass: "btn-green",
                           action: function () {
                               location.reload();
                           },
                       },
                   },
               });
           } else if (response.code == 403) {
               $.alert({
                   title: "Error!",
                   content: "CSRF Error Try Again",
                   type: "red",
                   theme:'modern',
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
           }else if (response.code == 500) {
            $.alert({
                title: "Error!",
                content: response.error,
                type: "red",
                theme:'modern',
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
        }else if (response.code == 409) {
            $.alert({
                title: "Error!",
                content: response.error,
                type: "red",
                theme:'modern',
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
        } else {
               $.alert({
                   title: "Error!",
                   content: "Something went wrong!",
                   type: "red",
                   theme:'modern',
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
           }
       },
       error: function (xhr, status, error) {
           $("#loader").hide();
           console.error("Error:", error);
           $.alert({
               title: "Error!",
               content: "Something went wrong!",
               type: "red",
               buttons: {
                   okay: {
                       text: "Okay",
                       btnClass: "btn-red",
                       action: function () {
                           $("#loader").hide();
                           location.reload();
                       },
                   },
               },
           });
       },
   });

});
////User update