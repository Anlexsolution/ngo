$(document).ready(function(){
    $('.selectize').selectize();
});


//Get Details of the member
$('body').on('change','#txtSelectMember', function(){
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token
 
    var txtSelectMember = $('#txtSelectMember').val();
    formData.append('txtSelectMember', txtSelectMember);

    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestGetMemberDetails(formData);
    });

});

function makeAjaxRequestGetMemberDetails(formData) {
    $.ajax({
        url: "/get-member-details",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function () {
            $("#loader").show();
        },
        success: function (response) {

             if(response.code == 200){
                const divDirectSavings = document.getElementById('divDirectSavings');
                if($('#txtSelectMember').val() == '') {
                    divDirectSavings.hidden = true;
                }else{
                    var firstName = response.member['firstName'];
                    var lastName = response.member['lastName'];
                    var address = response.member['address'];
                    var nicNumber = response.member['nicNumber'];
                    var newAccountNumber = response.member['newAccountNumber'];
                    var oldAccountNumber = response.member['oldAccountNumber'];
                    var totalAmount = response.saving;

                    $('#txtMemberFirstName').html('<h6>'+firstName+'</h6>');
                    $('#txtMemberLastName').html('<h6>'+lastName+'</h6>');
                    $('#txtAddress').html('<h6>'+address+'</h6>');
                    $('#txtNic').html('<h6>'+nicNumber+'</h6>');
                    $('#txtNewAccountNumber').html('<h6>'+newAccountNumber+'</h6>');
                    $('#txtOldAccountNumber').html('<h6>'+oldAccountNumber+'</h6>');
                    $('#txtTotalSavingAmount').html('<h6>'+totalAmount+'</h6>');
                    divDirectSavings.hidden = false;
                }
                $("#loader").hide();
             }else{
             handleResponse(response);
             }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
 }
 //Get Details of the member

 //Save Direct Savings Information
$('body').on('click','#btnSaveDirectSaving', function(){
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token
 
    var txtSelectMember = $('#txtSelectMember').val();
    formData.append('txtSelectMember', txtSelectMember);

    var txtAmount = $('#txtAmount').val();
    formData.append('txtAmount', txtAmount);

    if(txtAmount == ''){
        $('#txtAmount').focus();
        $.alert({
            title: "Error!",
            content: "Please fill the saving Amount",
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
        makeAjaxRequestDirectSavings(formData);
    });

});

function makeAjaxRequestDirectSavings(formData) {
    $.ajax({
        url: "/insert-direct-savings",
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
 //Save Direct Savings Information