////Create Main Qualification
$('body').on('click', '#btnCreateQualification', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtQualificationName = $('#txtQualificationName').val();
    formData.append('txtQualificationName', txtQualificationName);

    if (txtQualificationName == '') {
        $.alert({
            title: "Error!",
            content: "Please fill the Qualification name",
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
        makeAjaxRequestQualification(formData);
    });

});

function makeAjaxRequestQualification(formData) {
    $.ajax({
        url: "/add-qualification-data",
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
////Create Main Qualification


///Show Sub Modal
$('body').on('click', '.btnSubQualificationModalShow', function () {
    var quaId = $(this).data('id');
    $('#txtQualificationId').val(quaId);

    $('#addSubQualificationModal').modal('show');
});
///Show Sub Modal


///create Sub Qualification
$('body').on('click', '#btnCreateSubQualification', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtQualificationId = $('#txtQualificationId').val();
    formData.append('txtQualificationId', txtQualificationId);

    var txtSubQualificationName = $('#txtSubQualificationName').val();
    formData.append('txtSubQualificationName', txtSubQualificationName);

    if (txtSubQualificationName == '') {
        $.alert({
            title: "Error!",
            content: "Please fill the  sub Qualification name",
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
        makeAjaxRequestSubQualification(formData);
    });

});

function makeAjaxRequestSubQualification(formData) {
    $.ajax({
        url: "/add-sub-qualification-data",
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
///create Sub Qualification
