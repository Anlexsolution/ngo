$(document).ready(function(){
    $('.selectize').selectize();

$(document).on("click", ".btnEditVillage", function () {
    let id = $(this).data("id");
    let name = $(this).data("name");
    let divisionId = $(this).data("division");

    $("#editVillageId").val(id);
    $("#editVillageName").val(name);

    // Check if Selectize is applied
    if ($("#editDivisionId")[0].selectize) {
        // Selectize dropdown
        $("#editDivisionId")[0].selectize.setValue(divisionId);
    } else {
        // Normal select
        $("#editDivisionId").val(divisionId);
    }

    $("#villageEditModal").modal("show");
});

})

////village Update
$('body').on('click', '#updateVillageBtn', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var editVillageId = $('#editVillageId').val();
   formData.append('editVillageId', editVillageId);

   var editDivisionId = $('#editDivisionId').val();
   formData.append('editDivisionId', editDivisionId);

      var editVillageName = $('#editVillageName').val();
   formData.append('editVillageName', editVillageName);

   if(editVillageName == ''){
    $('#editVillageName').focus();
       $.alert({
           title: "Error!",
           content: "Please fill the village name",
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
       url: "/updatevillagedata",
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
                   content: "Village Updated successfully!",
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
////village Update

////village create
$('body').on('click', '#btnCreateVillage', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var villageName = $('#villageName').val();
   formData.append('villageName', villageName);

   var divisionId = $('#divisionId').val();
   formData.append('divisionId', divisionId);

   if(villageName == ''){
    $('#villageName').focus();
       $.alert({
           title: "Error!",
           content: "Please fill the village name",
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
       url: "/createvillagedata",
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
                   content: "Village Created successfully!",
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
////village create

//open delete modal
$('body').on('click', '.btnDeleteVillageModal', function(){
    var villageId = $(this).attr('data-id');
    $('#txtVillageId').val(villageId);
    $('#villageDeleteModal').modal('show');
});
//open delete modal

////VIllage delete
$('body').on('click', '#confirmDeleteVillageBtn', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtVillageId = $('#txtVillageId').val();
   formData.append('txtVillageId', txtVillageId);

    // AJAX request
    $.ajax({
       url: "/delete-village-data",
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
                   content: "Village deleted successfully!",
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
////VIllage delete
