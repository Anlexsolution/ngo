////login
$('body').on('click', '#btnSignIn', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);

    var email = $('#email').val();
    formData.append('email', email);

    var password = $('#password').val();
    formData.append('password', password);

    // grecaptcha.ready(function() {
    //     grecaptcha.execute('RECAPTCHA_SITE_KEY', { action: 'login' }).then(function(token) {
    //         formData.append('captcha', token);
    //         console.log(token); // log the token to check
    //         makeAjaxRequest(formData);
    //     });
    // });
    if (email === '') {
        showAlert("Error!", "Please fill the email address");
        return false;
    }

    if (password === '') {
        showAlert("Error!", "Please fill the password");
        return false;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);

                console.log(latitude)
                console.log(longitude)
                makeAjaxRequest(formData);
            },
            (error) => {
                console.error("Geolocation error:", error);
                showAlert("Error!", "Unable to retrieve location. Please try again.");
                $("#loader").hide();
            }
        );
    } else {
        showAlert("Error!", "Geolocation is not supported by your browser.");
        $("#loader").hide();
    }
});

function makeAjaxRequest(formData) {
    $.ajax({
        url: "/authendicate",
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



////login
$('body').on('click', '#btnSignInMember', function () {
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);

    var nicNumber = $('#nicNumber').val();
    formData.append('nicNumber', nicNumber);

    var password = $('#txtpassword').val();
    formData.append('password', password);

    // grecaptcha.ready(function() {
    //     grecaptcha.execute('RECAPTCHA_SITE_KEY', { action: 'login' }).then(function(token) {
    //         formData.append('captcha', token);
    //         console.log(token); // log the token to check
    //         makeAjaxRequest(formData);
    //     });
    // });
    if (nicNumber === '') {
        showAlert("Error!", "Please fill the nic number");
        return false;
    }

    if (password === '') {
        showAlert("Error!", "Please fill the password");
        return false;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);

                console.log(latitude)
                console.log(longitude)
                makeAjaxRequestMember(formData);
            },
            (error) => {
                console.error("Geolocation error:", error);
                showAlert("Error!", "Unable to retrieve location. Please try again.");
                $("#loader").hide();
            }
        );
    } else {
        showAlert("Error!", "Geolocation is not supported by your browser.");
        $("#loader").hide();
    }
});

function makeAjaxRequestMember(formData) {
    $.ajax({
        url: "/authendicate_member",
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
        location.href = '/show_member/' + response.encMemId;
    }else  if (response.code == 201) {
        location.href = '/otp_verify/' + response.email + '/' + response.password;
    } else {
        let message = response.error || "Something went wrong. Please try again.";
        showAlert("Error!", message);
    }
        },
        error: function (xhr, status, error) {
            $("#loader").hide();
            console.error("Error:", error);
            showAlert("Error!", "Something went wrong!");
        },
    });
}


$('body').on('click', '#btnVerifyOtp', function () {
    console.log("Button clicked!");
    $("#loader").show();
    var formData = new FormData();

    // Get the CSRF token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
    formData.append("_token", CSRF_TOKEN);

    var email = $('#txtEmail').val();
    formData.append('email', email);

    var password = $('#txtPassword').val();
    formData.append('password', password);

      let otpCode = '';

    // Loop through all OTP input fields
    $('.auth-input').each(function () {
      otpCode += $(this).val();
    });

    formData.append('otpCode', otpCode);

    // grecaptcha.ready(function() {
    //     grecaptcha.execute('RECAPTCHA_SITE_KEY', { action: 'login' }).then(function(token) {
    //         formData.append('captcha', token);
    //         console.log(token); // log the token to check
    //         makeAjaxRequest(formData);
    //     });
    // });
    if (email === '') {
        showAlert("Error!", "Please fill the email address");
        return false;
    }

    if (password === '') {
        showAlert("Error!", "Please fill the password");
        return false;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            (position) => {
                const latitude = position.coords.latitude;
                const longitude = position.coords.longitude;
                formData.append('latitude', latitude);
                formData.append('longitude', longitude);

                console.log(latitude)
                console.log(longitude)
                makeAjaxRequestOtpVerify(formData);
            },
            (error) => {
                console.error("Geolocation error:", error);
                showAlert("Error!", "Unable to retrieve location. Please try again.");
                $("#loader").hide();
            }
        );
    } else {
        showAlert("Error!", "Geolocation is not supported by your browser.");
        $("#loader").hide();
    }
});

function makeAjaxRequestOtpVerify(formData) {
    $.ajax({
        url: "/otp-verify-data",
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




function handleResponse(response) {
    if (response.code == 200) {
        location.href = '/dashboard';
    }else  if (response.code == 201) {
        location.href = '/otp_verify/' + response.email + '/' + response.password;
    } else {
        let message = response.error || "Something went wrong. Please try again.";
        showAlert("Error!", message);
    }
}

function showAlert(title, content) {
    $.alert({
        title: title,
        content: content,
        type: "red",
        theme: 'modern',
        buttons: {
            okay: {
                text: "Okay",
                btnClass: "btn-red",
            },
        },
    });
}
////login


