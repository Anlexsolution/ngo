$('body').on('click', '#btnCreateDocument', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMemberId = $('#txtMemberId').val();
    formData.append('txtMemberId', txtMemberId);

    var txtTitle = $('#txtTitle').val();
    formData.append('txtTitle', txtTitle);

    let fileInput = $("#txtDocument")[0].files[0];
    formData.append('txtDocument', fileInput);

    if (txtTitle == '') {
        $('#txtTitle').focus();
        $.alert({
            title: "Error!",
            content: "Please Enter a title",
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

    if (!fileInput) {
        $.alert({
            title: "Error!",
            content: "Please select a file",
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

    let allowedTypes = ['application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/pdf', 'image/jpeg', 'image/png'];

    if (!allowedTypes.includes(fileInput.type)) {
        $.alert({
            title: "Error!",
            content: "Invalid file type. Please select Word, Excel, PDF, JPG, or PNG.",
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
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestUploadDoc(formData);
    });

});

function makeAjaxRequestUploadDoc(formData) {
    $.ajax({
        url: "/upload-member-documents",
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


$('body').on('click', '#btnCreateNote', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMemberId = $('#txtMemberId').val();
    formData.append('txtMemberId', txtMemberId);

    var txtTitle = $('#txtTitleNote').val();
    formData.append('txtTitle', txtTitle);

    var txtDescription = $('#txtDescription').val();
    formData.append('txtDescription', txtDescription);

    if (txtTitle == '') {
        $('#txtTitle').focus();
        $.alert({
            title: "Error!",
            content: "Please Enter a title",
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

    if (txtDescription == '') {
        $('#txtDescription').focus();
        $.alert({
            title: "Error!",
            content: "Please Enter a description",
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
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestNote(formData);
    });

});

function makeAjaxRequestNote(formData) {
    $.ajax({
        url: "/create-member-notes",
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




$('body').on('click', '#btnUpdateProfile', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMemberId = $('#txtMemberId').val();
    formData.append('txtMemberId', txtMemberId);

    let fileInput = $("#txtProfile")[0].files[0];
    formData.append('txtDocument', fileInput);

    if (!fileInput) {
        $.alert({
            title: "Error!",
            content: "Please select a file",
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

    let allowedTypes = ['image/jpeg', 'image/png'];

    if (!allowedTypes.includes(fileInput.type)) {
        $.alert({
            title: "Error!",
            content: "Invalid file type. Please select Word, Excel, PDF, JPG, or PNG.",
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
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequest(formData);
    });

});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/update-profile-image",
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



$('body').on('click', '#btnUpdateSignature', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMemberId = $('#txtSigMemberId').val();
    formData.append('txtMemberId', txtMemberId);

    let fileInput = $("#txtSignature")[0].files[0];
    formData.append('txtDocument', fileInput);

    if (!fileInput) {
        $.alert({
            title: "Error!",
            content: "Please select a file",
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

    let allowedTypes = ['image/jpeg', 'image/png'];

    if (!allowedTypes.includes(fileInput.type)) {
        $.alert({
            title: "Error!",
            content: "Invalid file type. Please select Word, Excel, PDF, JPG, or PNG.",
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
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestSign(formData);
    });

});

function makeAjaxRequestSign(formData) {
    $.ajax({
        url: "/update-signature-image",
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




$('body').on('click', '#btnCreateMemberUser', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMemberId = $('#txtMemberIdGet').val();
    formData.append('txtMemberId', txtMemberId);

    var password = $('#password').val();
    formData.append('password', password);


    var confirmPassword = $('#confirmPassword').val();
    formData.append('confirmPassword', confirmPassword);


    if (!password) {
        $.alert({
            title: "Error!",
            content: "Please enter password",
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

    if (!confirmPassword) {
        $.alert({
            title: "Error!",
            content: "Please enter confirm password",
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

    if (password != confirmPassword) {
        $.alert({
            title: "Error!",
            content: "Password and confirm password does not match",
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
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestMemUser(formData);
    });

});

function makeAjaxRequestMemUser(formData) {
    $.ajax({
        url: "/create-member-user",
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


$('body').on('click', '#btnSaveLocation', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);
    // Get the CSRF token

    var txtMapLattitude = $('#txtMapLattitude').val();
    formData.append('txtMapLattitude', txtMapLattitude);

    var txtMapLongitude = $('#txtMapLongitude').val();
    formData.append('txtMapLongitude', txtMapLongitude);

    var txtMemberId = $('#txtMemberId').val();
    formData.append('txtMemberId', txtMemberId);


    if (txtMapLattitude == '') {
        $('#txtMapLattitude').focus();
        $.alert({
            title: "Error!",
            content: "Please Enter a Latitude",
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

    if (txtMapLongitude == '') {
        $('#txtMapLongitude').focus();
        $.alert({
            title: "Error!",
            content: "Please Enter a Longitude",
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
    getUserLocation().then(({ latitude, longitude }) => {
        formData.append('latitude', latitude);
        formData.append('longitude', longitude);
        makeAjaxRequestLocation(formData);
    });

});

function makeAjaxRequestLocation(formData) {
    $.ajax({
        url: "/create-member-location",
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
