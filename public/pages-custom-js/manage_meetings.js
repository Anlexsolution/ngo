$(document).ready(function () {
    $('.selectize').selectize();
    $('#txtDivision').selectize();
    $('#txtVillage').selectize();
    $('#txtSmallGroup').selectize();
});


//Get VIllage
$('body').on('change', '#txtDivision', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtDivision = $('#txtDivision').val();
    formData.append('txtDivision', txtDivision);

    if (txtDivision == '') {
        $.alert({
            title: "Error!",
            content: "Please select the division",
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
        url: "/get-meeting-village-data",
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
                if ($("#txtVillage")[0].selectize) {
                    $("#txtVillage")[0].selectize.destroy();
                }
                $("#txtVillage").empty().append(response.villageOption);
                $("#txtVillage").selectize();
            }else{
                $("#txtVillage").empty();
                $("#txtVillage").append('<option value="">Select Village</option>');
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}
//Get VIllage


//Get Smalllgroup
$('body').on('change', '#txtVillage', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtDivision = $('#txtDivision').val();
    formData.append('txtDivision', txtDivision);

     var txtVillage = $('#txtVillage').val();
    formData.append('txtVillage', txtVillage);

    if (txtDivision == '') {
        $.alert({
            title: "Error!",
            content: "Please select the division",
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

       if (txtVillage == '') {
        $.alert({
            title: "Error!",
            content: "Please select the village",
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
        url: "/get-meeting-smallgroup-data",
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
                if ($("#txtVillage")[0].selectize) {
                    $("#txtVillage")[0].selectize.destroy();
                }
                $("#txtVillage").empty().append(response.villageOption);
                $("#txtVillage").selectize();
            }else{
                $("#txtVillage").empty();
                $("#txtVillage").append('<option value="">Select Village</option>');
            }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}
//Get Smalllgroup
