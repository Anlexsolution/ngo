$(document).ready(function(){
    $('.selectize').selectize();
    $('#txtSelectGnDivision').selectize();
});

////division change
$('body').on('change', '#txtSelectDivision', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSelectDivision = $('#txtSelectDivision').val();
   formData.append('txtSelectDivision', txtSelectDivision);

    // AJAX request
    $.ajax({
       url: "/get-gn-division-data",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       beforeSend: function () {
           $("#loader").show();
       },
       success: function (response) {
           if (response.code == 200) {
             $("#txtSelectGnDivision")[0].selectize.destroy();
             $("#txtSelectGnDivision").append(response.getGnDiv);
             $("#txtSelectGnDivision").selectize();
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
           $("#loader").hide();
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
////division change

////create gn division small group
$('body').on('click', '#btnCreateGnSmallGroup', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSelectDivision = $('#txtSelectDivision').val();
   formData.append('txtSelectDivision', txtSelectDivision);

   var txtSelectGnDivision = $('#txtSelectGnDivision').val();
   formData.append('txtSelectGnDivision', txtSelectGnDivision);

   var txtGnSmallGroup = $('#txtGnSmallGroup').val();
   formData.append('txtGnSmallGroup', txtGnSmallGroup);

   if(txtSelectDivision == ''){
    $('#txtSelectDivision').focus();
       $.alert({
           title: "Error!",
           content: "Please select division",
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

   if(txtSelectGnDivision == ''){
    $('#txtSelectGnDivision').focus();
       $.alert({
           title: "Error!",
           content: "Please select gn division",
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

   if(txtGnSmallGroup == ''){
    $('#txtGnSmallGroup').focus();
       $.alert({
           title: "Error!",
           content: "Please fill the smallgroup name",
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
       url: "/create-gndivision-smallgroup",
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
                   content: "smallgroup Created successfully!",
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
////create gn division small group