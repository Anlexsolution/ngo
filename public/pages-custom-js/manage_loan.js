$(document).ready(function(){
    $('.selectize').selectize();
    $('#txtSelectLoanAmount').selectize();
    $('#txtLoanPurposeSub').selectize();
});


$('body').on('change', '#txtLoanPurpose', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtLoanPurpose = $('#txtLoanPurpose').val();
    formData.append('txtMainCategory', txtLoanPurpose);

    if (txtLoanPurpose == '') {
        $.alert({
            title: "Error!",
            content: "Please select loan purpose",
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
                $("#txtLoanPurposeSub")[0].selectize.destroy();
                $("#txtLoanPurposeSub").empty();
                $("#txtLoanPurposeSub").append(response.getAllLoanOption);
                $("#txtLoanPurposeSub").selectize();
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

//Create Profeesion
$('body').on('click', '#btnGenerateLoanProduct', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSelectMember = $('#txtSelectMember').val();
   formData.append('txtSelectMember', txtSelectMember);

   var txtSelectLoanProduct = $('#txtSelectLoanProduct').val();
   formData.append('txtSelectLoanProduct', txtSelectLoanProduct);

   var txtSelectLoanAmount = $('#txtSelectLoanAmount').val();
   formData.append('txtSelectLoanAmount', txtSelectLoanAmount);

   var txtSelectLoanApprovalSet = $('#txtSelectLoanApprovalSet').val();
   formData.append('txtSelectLoanApprovalSet', txtSelectLoanApprovalSet);

   if(txtSelectLoanApprovalSet == ''){
    $.alert({
        title: "Error!",
        content: "Please select the approval",
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

if(txtSelectLoanAmount == ''){
    $.alert({
        title: "Error!",
        content: "Please select the loan amount",
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

   if(txtSelectMember == ''){
       $.alert({
           title: "Error!",
           content: "Please select the member",
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

   if(txtSelectLoanProduct == ''){
    $.alert({
        title: "Error!",
        content: "Please select the loan product",
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

$.ajax({
    url: "/get-loan-product-data",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function () {
        $("#loader").show();
    },
    success: function (response) {
        if (response.code == 200) {
            var loanProduct = response.getLoanProduct;
            var getLoanOfficer = response.getLoanOfficer;
            var getApprovalDetails = response.getApprovalDetails;
            $('#txtPricipal').val( response.getloanAmount);
            $('#txtPricipal').trigger('keyup');
            $('#getLoanOfficers').html(getLoanOfficer);
            $('#getApprovalDetails').html(getApprovalDetails);
            $('.selectizeApproval').selectize();
            $('#txtLoanOfficer').selectize();
            $('#txtProductName').val(loanProduct['productName']);
            $('#txtDescription').val(loanProduct['description']);
            $('#txtLoanTerm').val(loanProduct['defaultLoanTerm']);
            $('#txtRepaymentFrequency').val(loanProduct['repaymentFrequency']);
            $('#txtInterestRate').val(loanProduct['defaultInterest']);
            document.getElementById("loanProductDiv").style.display = "block";

            $("#loader").hide();
    }
},
    error: function (xhr, status, error) {
        $("#loader").hide();
        console.error("Error:", error);
        showAlert("Error!", "Something went wrong!");
    },
});
});

////Create Profeesion


//Create purpose
$('body').on('click', '#btnCreatePurpose', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var modalPurposeName = $('#modalPurposeName').val();
   formData.append('modalPurposeName', modalPurposeName);

   if(modalPurposeName == ''){
       $.alert({
           title: "Error!",
           content: "Please fill the purpose name",
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
       makeAjaxRequestPurpose(formData);
   });

});

function makeAjaxRequestPurpose(formData) {
   $.ajax({
       url: "/add-purpose-data",
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


////Create Sub Category
$('body').on('click', '#btnCreateSubCat', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSubCatName = $('#txtSubCatName').val();
   formData.append('txtSubCatName', txtSubCatName);

   var txtMainCatId = $('#txtMainCatId').val();
   formData.append('txtMainCatId', txtMainCatId);

   if(txtSubCatName == ''){
       $.alert({
           title: "Error!",
           content: "Please fill the sub category name",
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

   if(txtMainCatId == ''){
    $.alert({
        title: "Error!",
        content: "Please select the main category name",
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
       makeAjaxRequestSubCat(formData);
   });

});

function makeAjaxRequestSubCat(formData) {
   $.ajax({
       url: "/add-sub-category-data",
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
////Create Sub Category

$('body').on('keyup', '#txtPricipal', function(){
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtSelectLoanProduct = $('#txtSelectLoanProduct').val();
    formData.append('txtSelectLoanProduct', txtSelectLoanProduct);

    var txtPricipal = $('#txtPricipal').val();

    var validationCheckPrincipal = document.getElementById(
        "txtPricipal"
      );
    $.ajax({
        url: "/get-loan-product-data-check",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            if (response.code == 200) {
                var loanProduct = response.data;
                if (txtPricipal >= loanProduct['minimumPrincipal'] && txtPricipal <= loanProduct['maximumPrincipal']) {
                    validationCheckPrincipal.classList.add('is-valid');
                    validationCheckPrincipal.classList.remove('is-invalid');
                    $("#validationCheckPrincipal").html("" );
                } else {
                    validationCheckPrincipal.classList.add('is-invalid');
                    validationCheckPrincipal.classList.remove('is-valid');
                    $("#validationCheckPrincipal").html(
                        "<div id='validationServer03Feedback' class='invalid - feedback text-danger'>Please enter range " +
                        loanProduct['minimumPrincipal']  +
                          " to " +
                          loanProduct['maximumPrincipal'] +
                          "</div > "
                      );
                }
                $("#loader").hide();
            }else{
                $.alert({
                    title: 'Alert',
                    content: "Somthing went wrong",
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
                $("#loader").hide();
            }
            $("#loader").hide();

        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
})

$('body').on('keyup', '#txtLoanTerm', function(){
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtSelectLoanProduct = $('#txtSelectLoanProduct').val();
    formData.append('txtSelectLoanProduct', txtSelectLoanProduct);

    var txtLoanTerm = $('#txtLoanTerm').val();

    var validationCheckPrincipal = document.getElementById(
        "txtLoanTerm"
      );
    $.ajax({
        url: "/get-loan-product-data-check",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            if (response.code == 200) {
                var loanProduct = response.data;
                if (txtLoanTerm >= loanProduct['minimumLoanTerm'] && txtLoanTerm <= loanProduct['maximumLoanTerm']) {
                    validationCheckPrincipal.classList.add('is-valid');
                    validationCheckPrincipal.classList.remove('is-invalid');
                    $("#validationCheckTerm").html("" );
                } else {
                    validationCheckPrincipal.classList.add('is-invalid');
                    validationCheckPrincipal.classList.remove('is-valid');
                    $("#validationCheckTerm").html(
                        "<div id='validationServer03Feedback' class='invalid - feedback text-danger'>Please enter range " +
                        loanProduct['minimumLoanTerm']  +
                          " to " +
                          loanProduct['maximumLoanTerm'] +
                          "</div > "
                      );
                }
                $("#loader").hide();
            }else{
                $.alert({
                    title: 'Alert',
                    content: "Somthing went wrong",
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
                $("#loader").hide();
            }
            $("#loader").hide();

        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
})


$('body').on('keyup', '#txtInterestRate', function(){
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtSelectLoanProduct = $('#txtSelectLoanProduct').val();
    formData.append('txtSelectLoanProduct', txtSelectLoanProduct);

    var txtInterestRate = $('#txtInterestRate').val();

    var validationCheckPrincipal = document.getElementById(
        "txtInterestRate"
      );
    $.ajax({
        url: "/get-loan-product-data-check",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            if (response.code == 200) {
                var loanProduct = response.data;
                if (txtInterestRate >= loanProduct['minimumInterest'] && txtInterestRate <= loanProduct['maximumInterest']) {
                    validationCheckPrincipal.classList.add('is-valid');
                    validationCheckPrincipal.classList.remove('is-invalid');
                    $("#validationCheckInterest").html("" );
                } else {
                    validationCheckPrincipal.classList.add('is-invalid');
                    validationCheckPrincipal.classList.remove('is-valid');
                    $("#validationCheckInterest").html(
                        "<div id='validationServer03Feedback' class='invalid - feedback text-danger'>Please enter range " +
                        loanProduct['minimumInterest']  +
                          " to " +
                          loanProduct['maximumInterest'] +
                          "</div > "
                      );
                }
                $("#loader").hide();
            }else{
                $.alert({
                    title: 'Alert',
                    content: "Somthing went wrong",
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
                $("#loader").hide();
            }
            $("#loader").hide();

        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
})



//Create Loan
$('body').on('click', '#btnCreateLoanBasic', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSelectMember = $('#txtSelectMember').val();
   formData.append('txtSelectMember', txtSelectMember);

   var txtLoanId = $('#txtLoanId').val();
   formData.append('txtLoanId', txtLoanId);

   var txtSelectLoanProduct = $('#txtSelectLoanProduct').val();
   formData.append('txtSelectLoanProduct', txtSelectLoanProduct);


   var txtPricipal = $('#txtPricipal').val();
   formData.append('txtPricipal', txtPricipal);

   var txtLoanTerm = $('#txtLoanTerm').val();
   formData.append('txtLoanTerm', txtLoanTerm);

   var txtRepaymentFrequency = $('#txtRepaymentFrequency').val();
   formData.append('txtRepaymentFrequency', txtRepaymentFrequency);

   var txtInterestRate = $('#txtInterestRate').val();
   formData.append('txtInterestRate', txtInterestRate);

   var txtRepaymentPreriod = $('#txtRepaymentPreriod').val();
   formData.append('txtRepaymentPreriod', txtRepaymentPreriod);

   var txtPer = $('#txtPer').val();
   formData.append('txtPer', txtPer);

   var txtInterestType = $('#txtInterestType').val();
   formData.append('txtInterestType', txtInterestType);

   var txtLoanOfficer = $('#txtLoanOfficer').val();
   formData.append('txtLoanOfficer', txtLoanOfficer);

   var txtLoanPurpose = $('#txtLoanPurpose').val();
   formData.append('txtLoanPurpose', txtLoanPurpose);


   var txtLoanPurposeSub = $('#txtLoanPurposeSub').val();
   formData.append('txtLoanPurposeSub', txtLoanPurposeSub);

   var txtExpectedFirstRepaymentDate = $('#txtExpectedFirstRepaymentDate').val();
   formData.append('txtExpectedFirstRepaymentDate', txtExpectedFirstRepaymentDate);

   let approvalData = [];

$(".getApprovalData").each(function() {
    let approvalId = $(this).attr("id");
    let selectedValue = $(this).val();

    if (selectedValue) {
    approvalData.push({
        id: approvalId,
        value: selectedValue
    });
}
});

formData.append('approval', JSON.stringify(approvalData));

   if(txtSelectMember == ''){
       $.alert({
           title: "Error!",
           content: "Please select member",
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
       makeAjaxRequestPurposeLoan(formData);
   });

});

function makeAjaxRequestPurposeLoan(formData) {
   $.ajax({
       url: "/create-loan-first-step",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       beforeSend: function () {
           $("#loader").show();
       },
       success: function (response) {
        if(response.code == 200){
            $('#selectGuarantors').html(response.selectGurantos);
            $('#selectCurrentes').selectize({
                maxItems: null,
            });
            $('#txtLoanId').val(response.loanId);
            $('#addGuarantorsModal').modal('show');
        }
           $("#loader").hide();

       },
       error: function (xhr, status, error) {
           $("#loader").hide();
           console.error("Error:", error);
           showAlert("Error!", "Something went wrong!");
       },
   });
}
////Create Loan

//Assign Guarantors
$('body').on('click', '#btnAssignGuarantors', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var selectCurrentes = $('#selectCurrentes').val();
   formData.append('selectCurrentes', selectCurrentes);

   var txtLoanId = $('#txtLoanId').val();
   formData.append('txtLoanId', txtLoanId);

   if(selectCurrentes == ''){
       $.alert({
           title: "Error!",
           content: "Please select Guarantors",
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
       makeAjaxRequestAssignLoan(formData);
   });

});

function makeAjaxRequestAssignLoan(formData) {
   $.ajax({
       url: "/create-loan-guarantors-step",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       beforeSend: function () {
           $("#loader").show();
       },
       success: function (response) {
        if(response.code == 200){
            var txtLoanIdEnc = response.txtLoanIdEnc;
            $.alert({
                title: 'Success',
                content: 'Assigned successfully',
                type: "green",
                theme: 'modern',
                buttons: {
                    okay: {
                        text: "Okay",
                        btnClass: "btn-green",
                        action: function () {
                            location.href='/loan_follower/' + txtLoanIdEnc
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
           showAlert("Error!", "Something went wrong!");
       },
   });
}
//Assign Guarantors


$('body').on('click', '#calculateLoanSchedule', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtPricipal = $('#txtPricipal').val();
   formData.append('txtPricipal', txtPricipal);

   var txtInterestRate = $('#txtInterestRate').val();
   formData.append('txtInterestRate', txtInterestRate);

   var txtLoanTerm = $('#txtLoanTerm').val();
   formData.append('txtLoanTerm', txtLoanTerm);

   var txtRepaymentFrequency = $('#txtRepaymentFrequency').val();
   formData.append('txtRepaymentFrequency', txtRepaymentFrequency);

   var txtRepaymentPreriod = $('#txtRepaymentPreriod').val();
   formData.append('txtRepaymentPreriod', txtRepaymentPreriod);

   var txtExpectedFirstRepaymentDate = $('#txtExpectedFirstRepaymentDate').val();
   formData.append('txtExpectedFirstRepaymentDate', txtExpectedFirstRepaymentDate);

   var txtPer = $('#txtPer').val();
   formData.append('txtPer', txtPer);

   getUserLocation().then(({ latitude, longitude }) => {
    formData.append('latitude', latitude);
    formData.append('longitude', longitude);
    makeAjaxRequestCalculate(formData);
});

});

function makeAjaxRequestCalculate(formData) {
    $.ajax({
        url: "/calculate-loan-amount",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {
            $("#loader").hide();
            if(response.code == 200){
                var loanSchedule = response.loanSchedule;
                $('#loanScheduleTable').html(loanSchedule);
                $('#loanTable').DataTable();
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}


$('body').on('change', '#txtSelectMember', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtSelectMember = $('#txtSelectMember').val();
   formData.append('txtSelectMember', txtSelectMember);

   if(txtSelectMember == ''){
       $.alert({
           title: "Error!",
           content: "Please select the member",
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
       makeAjaxRequestAmount(formData);
   });

});

function makeAjaxRequestAmount(formData) {
   $.ajax({
       url: "/get-loan-request-amount-data",
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
            $("#txtSelectLoanAmount")[0].selectize.destroy();
            $("#txtSelectLoanAmount").empty();
            $("#txtSelectLoanAmount").append(response.getAllLoanOption);
            $("#txtSelectLoanAmount").selectize();
            $("#loader").hide();
           }else{
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


$('body').on('click', '.btnUpdateMainCategory', function(){
    $("#loader").show();

    var MainCatId = $(this).attr('data-id');
    var txtMainCatName = $(this).attr('data-name');

    $('#txtMainCatIdUpdate').val(MainCatId);
    $('#txtUpdateMainCat').val(txtMainCatName);
    $('#updateMaincategoryModal').modal('show');
    $("#loader").hide();
});

$('body').on('click', '.btnDeleteMainCat', function(){
    $("#loader").show();

    var MainCatId = $(this).attr('data-id');

    $('#txtMainCatDeleteId').val(MainCatId);
    $('#mainCatDeleteModal').modal('show');
    $("#loader").hide();
});

//Update Main Category
$('body').on('click', '#btnUpdateMainCat', function(){
    $("#loader").show();
   var formData = new FormData();

   // Get the CSRF token
   var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
   formData.append("_token", CSRF_TOKEN);
   // Get the CSRF token

   var txtMainCatId = $('#txtMainCatIdUpdate').val();
   formData.append('txtMainCatId', txtMainCatId);

   var txtUpdateMainCat = $('#txtUpdateMainCat').val();
   formData.append('txtUpdateMainCat', txtUpdateMainCat);



   getUserLocation().then(({ latitude, longitude }) => {
       formData.append('latitude', latitude);
       formData.append('longitude', longitude);
       makeAjaxRequestUpdateMainCat(formData);
   });

});

function makeAjaxRequestUpdateMainCat(formData) {
   $.ajax({
       url: "/update-purpose-main-cat-data",
       type: "POST",
       data: formData,
       processData: false,
       contentType: false,
       beforeSend: function () {
           $("#loader").show();
       },
       success: function (response) {
        handleResponse(response);

       },
       error: function (xhr, status, error) {
           $("#loader").hide();
           console.error("Error:", error);
           showAlert("Error!", "Something went wrong!");
       },
   });
}
////Update Main Category


