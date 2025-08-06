$(document).ready(function(){
    $('.selectize').selectize();
        $('#txtSubCategory').selectize();
});

$('body').on('change', '#txtMainCategory', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMainCategory = $('#txtMainCategory').val();
    formData.append('txtMainCategory', txtMainCategory);

    if (txtMainCategory == '') {
        $.alert({
            title: "Error!",
            content: "Please select the main Category",
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
        makeAjaxRequestGet(formData);
    });

});

function makeAjaxRequestGet(formData) {
    $.ajax({
        url: "/get-loan-purpose-sub-cat-data",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            $("#loader").hide();
            if (response.code === 200) {
                $("#txtSubCategory")[0].selectize.destroy();
                $("#txtSubCategory").empty();
                $("#txtSubCategory").append(response.getAllLoanOption);
                $("#txtSubCategory").selectize();
                $("#loader").hide();
            } else {
                $.alert({
                    title: "Alert",
                    content: "Something went wrong",
                    icon: "fa fa-exclamation-triangle",
                    type: "red",
                    theme: "modern",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-red",
                            action: function () {
                                $("#page-loader").hide();
                            },
                        },
                    },
                });
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}

////Crreate Product
$('body').on('click', '#btnCreateProduct', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtProductName = $('#txtProductName').val();
   formData.append('txtProductName', txtProductName);

   var txtDescription = $('#txtDescription').val();
   formData.append('txtDescription', txtDescription);

   var txtDefaultPrincipel = $('#txtDefaultPrincipel').val();
   formData.append('txtDefaultPrincipel', txtDefaultPrincipel);

   var txtMinimumPrincipel = $('#txtMinimumPrincipel').val();
   formData.append('txtMinimumPrincipel', txtMinimumPrincipel);

   var txtMaximumPrincipel = $('#txtMaximumPrincipel').val();
   formData.append('txtMaximumPrincipel', txtMaximumPrincipel);

   var txtDefaultLoanTerm = $('#txtDefaultLoanTerm').val();
   formData.append('txtDefaultLoanTerm', txtDefaultLoanTerm);

   var txtMinimumLoanTerm = $('#txtMinimumLoanTerm').val();
   formData.append('txtMinimumLoanTerm', txtMinimumLoanTerm);

   var txtMaximumLoanTerm = $('#txtMaximumLoanTerm').val();
   formData.append('txtMaximumLoanTerm', txtMaximumLoanTerm);

   var txtRepaymentFrequency = $('#txtRepaymentFrequency').val();
   formData.append('txtRepaymentFrequency', txtRepaymentFrequency);

   var txtRepaymentPreriod = $('#txtRepaymentPreriod').val();
   formData.append('txtRepaymentPreriod', txtRepaymentPreriod);

   var txtDefaultInterest = $('#txtDefaultInterest').val();
   formData.append('txtDefaultInterest', txtDefaultInterest);

   var txtMinimumInterest = $('#txtMinimumInterest').val();
   formData.append('txtMinimumInterest', txtMinimumInterest);

   var txtMaximumInterest = $('#txtMaximumInterest').val();
   formData.append('txtMaximumInterest', txtMaximumInterest);

   var txtPer = $('#txtPer').val();
   formData.append('txtPer', txtPer);

   var txtActive = $('#txtActive').val();
   formData.append('txtActive', txtActive);

   var txtInterestType = $('#txtInterestType').val();
   formData.append('txtInterestType', txtInterestType);

      var txtMainCategory = $('#txtMainCategory').val();
   formData.append('txtMainCategory', txtMainCategory);

      var txtSubCategory = $('#txtSubCategory').val();
   formData.append('txtSubCategory', txtSubCategory);

   var txtApprovalCount = $('#txtApprovalCount').val();
   formData.append('txtApprovalCount', '0');

   if(txtProductName == ''){
       $.alert({
           title: "Error!",
           content: "Please fill the product name",
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

      if(txtMainCategory == ''){
       $.alert({
           title: "Error!",
           content: "Please select the main category",
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

   if(txtSubCategory == ''){
       $.alert({
           title: "Error!",
           content: "Please select the sub category",
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

//    if(txtApprovalCount == ''){
//     $.alert({
//         title: "Error!",
//         content: "Please fill the Approval Count",
//         type: "red",
//         theme: 'modern',
//         buttons: {
//             okay: {
//                 text: "Okay",
//                 btnClass: "btn-red",
//                 action: function () {
//                     $("#loader").hide();
//                 },
//             },
//         },
//     });
//     return false;
// }

   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       productInsert(formData);
   });

});

function productInsert(formData) {
   $.ajax({
       url: "/create-product-data",
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
////Crreate Product
