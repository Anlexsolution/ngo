$(document).ready(function() {
    $('#deathDonationTable').DataTable({
        responsive: true,
    });
    $('.selectize').selectize();
});


//Create Donation
$('body').on('click', '#btnCreateDonation', function(){
     $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMember = $('#txtMember').val();
    formData.append('txtMember', txtMember);

    var txtRelative = $('#txtRelative').val();
    formData.append('txtRelative', txtRelative);

    var txtName = $('#txtName').val();
    formData.append('txtName', txtName);

    var txtRemarks = $('#txtRemarks').val();
    formData.append('txtRemarks', txtRemarks);

    var txtUserType = $('#txtUserType').val();
    formData.append('txtUserType', txtUserType);

    if(txtMember == ''){
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

    if(txtRelative == ''){
        $.alert({
            title: "Error!",
            content: "Please select relative",
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

    if(txtName == ''){
        $.alert({
            title: "Error!",
            content: "Please fill the name",
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
    if(txtUserType == ''){
        $.alert({
            title: "Error!",
            content: "Please select user type",
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
        url: "/add-death-donation-data",
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
////Create Donation
