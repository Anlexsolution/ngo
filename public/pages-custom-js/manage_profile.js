$(document).ready(function () {
    $('body').on('click', '#btnUploadProfile', function () {
        //alert("hi");

        $("#loader").show();
        var formData = new FormData();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
        formData.append("_token", CSRF_TOKEN);

        var txtUserId = $('#txtUserId').val();
        formData.append('txtUserId', txtUserId);

        let fileInput = $("#txtUploadProfile")[0].files[0];
        formData.append('txtUploadProfile', fileInput);

        if (!fileInput) {
            $.alert({
                title: "Error!",
                content: "Please select a profile image.",
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

        let allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        if (!allowedTypes.includes(fileInput.type)) {
            $.alert({
                title: "Error!",
                content: "Invalid file type. Only JPG, JPEG, PNG, or WEBP files are allowed.",
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

        makeAjaxRequest(formData);
    });

    function makeAjaxRequest(formData) {
        $.ajax({
            url: "/upload-profile",
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


    // Update Profile Data
    $('body').on('click', '#btnUpdateProfileData', function (e) {
        // alert("hi");
        e.preventDefault();

        $("#loader").show(); 

        let formData = new FormData();
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

        formData.append("_token", CSRF_TOKEN);
        formData.append("txtUpdateUserId", $('#txtUpdateUserId').val());
        formData.append("txtFullname", $('#txtFullname').val());
        formData.append("dateOfBirth", $('#dateOfBirth').val());
        formData.append("gender", $('#gender').val());
        formData.append("txtPhoneNumber", $('#txtPhoneNumber').val());

        $.ajax({
            url: "/update-profile-data",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#loader").hide();
                if (response.code === 200) {
                    $.alert({
                        title: "Success!",
                        content: response.success,
                        type: "green",
                        theme: "modern",
                        buttons: {
                            okay: {
                                text: "Okay",
                                btnClass: "btn-green",
                                action: function () {
                                    $('#updateProfileDataModal').modal('hide');
                                    location.reload();
                                }
                            }
                        }
                    });
                } else {
                    $.alert({
                        title: "Error!",
                        content: response.error,
                        type: "red",
                        theme: "modern",
                        buttons: {
                            okay: {
                                text: "Okay",
                                btnClass: "btn-red"
                            }
                        }
                    });
                }
            },
            error: function (xhr, status, error) {
                $("#loader").hide();
                $.alert({
                    title: "Error!",
                    content: "An error occurred while updating profile.",
                    type: "red",
                });
            },
        });
    });


    //Change Password
    $(document).on('click', '#btnChangePassword', function () {
        // alert("hi");
    let userId = $('#changePasswordUserId').val();
    let currentPassword = $('#currentPassword').val();
    let newPassword = $('#newPassword').val();
    let confirmPassword = $('#confirmPassword').val();
    let token = $('meta[name="csrf-token"]').attr('content');

    if (!currentPassword || !newPassword || !confirmPassword) {
        $.alert({
            title: "Error!",
            content: "All fields are required.",
            type: "red",
            theme: "modern",
            buttons: {
                okay: {
                    text: "Okay",
                    btnClass: "btn-red"
                }
            }
        });
        return;
    }

    if (newPassword !== confirmPassword) {
        $.alert({
            title: "Error!",
            content: "New and confirm password do not match.",
            type: "red",
            theme: "modern",
            buttons: {
                okay: {
                    text: "Okay",
                    btnClass: "btn-red"
                }
            }
        });
        return;
    }

    $.ajax({
        url: "/change-password",
        type: "POST",
        data: {
            _token: token,
            userId: userId,
            currentPassword: currentPassword,
            newPassword: newPassword
        },
        success: function (response) {
            $("#loader").hide();
            if (response.code === 200) {
                $.alert({
                    title: "Success!",
                    content: response.success,
                    type: "green",
                    theme: "modern",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-green",
                            action: function () {
                                $('#changePasswordModal').modal('hide');
                                location.reload();
                            }
                        }
                    }
                });
            } else {
                $.alert({
                    title: "Error!",
                    content: response.error,
                    type: "red",
                    theme: "modern",
                    buttons: {
                        okay: {
                            text: "Okay",
                            btnClass: "btn-red"
                        }
                    }
                });
            }
        },
        error: function () {
            $.alert({
                title: "Error!",
                content: "Something went wrong.",
                type: "red",
                theme: "modern",
                buttons: {
                    okay: {
                        text: "Okay",
                        btnClass: "btn-red"
                    }
                }
            });
        }
    });
});


});
