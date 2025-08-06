////Interest wise
$('body').on('click', '.btnInterestWise', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var loanId = $(this).attr('data-id');
   formData.append('loanId', loanId);

    // AJAX request
    $.ajax({
       url: "/loan-interest-wise-data",
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
                   content: "Interest wised successfully!",
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
           }else if (response.code == 403) {
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
////Interest wise


////Write Off
$('body').on('click', '.btnWriteOff', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var loanId = $(this).attr('data-id');
   formData.append('loanId', loanId);

    // AJAX request
    $.ajax({
       url: "/loan-write-off-data",
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
                   content: "Write off successfully!",
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
           }else if (response.code == 403) {
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
////Write off
