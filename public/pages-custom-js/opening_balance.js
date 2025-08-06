$(document).ready(function(){
    $("#loader").show();
    $('.selectize').selectize();
   var tableOpening =  $('#tableOpeningBalance').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excelHtml5',
            'pdfHtml5'
        ],
        scrollX: true, 
        scrollY: '400px', 
        scrollCollapse: true 
    });

    $("#divisionId").on("change", function () {
        var status = $(this).val();
        tableOpening.column(3).search(status).draw();
      });

    $("#loader").hide();
});

////opening balance update
$('body').on('click', '#btnSavingAmountSubmit', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   const inputFields = document.querySelectorAll('.savingsTotalUpdateField');
   const data = [];
   inputFields.forEach(inputField => {
       data.push({
           id: inputField.id,
           value: inputField.value
       });
   });
   formData.append('allField', JSON.stringify(data));

   const inputFieldsDeath = document.querySelectorAll('.deathTotalUpdateField');
   const dataDeath = [];
   inputFieldsDeath.forEach(inputField => {
    dataDeath.push({
           id: inputField.id,
           value: inputField.value
       });
   });
   formData.append('allFieldDeath', JSON.stringify(dataDeath));
 

    // AJAX request
    $.ajax({
       url: "/create-opening-savings-balance",
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
                   content: " Created successfully!",
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
           }else if (response.code == 500 || response.code == 404 || response.code == 422) {
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
////opening balance update

$('body').on('change', '#divisionId', function(){
    var divisionId = $('#divisionId').val();

})