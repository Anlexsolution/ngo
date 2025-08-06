<!doctype html>
<html lang="en" class="light-style layout-wide customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="vertical-menu-template" data-style="light">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>Login - swod</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.rawgit.com/craftpip/jquery-confirm/master/dist/jquery-confirm.min.css">

  <!-- Icons -->
  <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
  <link rel="stylesheet" href="../../assets/vendor/fonts/tabler-icons.css" />
  <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../../assets/vendor/libs/node-waves/node-waves.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
  <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />

  <!-- Page CSS -->
  <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />

  <!-- Helpers -->
  <script src="../../assets/vendor/js/helpers.js"></script>
  <script src="../../assets/vendor/js/template-customizer.js"></script>
  <script src="../../assets/js/config.js"></script>
</head>

<body>
  <!-- Content -->
  <div class="authentication-wrapper authentication-basic px-6">
    <div class="authentication-inner py-6">
      <div class="card">
        <div class="card-body">
          <input type="text" class="form-control" id="txtEmail" value="{{$email}}" hidden />
          <input type="text" class="form-control" id="txtPassword" value="{{$password}}" hidden />
          <div class="app-brand justify-content-center mb-6">
            <a href="index.html" class="app-brand-link">
              <img src="../../assets/img/logo.png" alt="" height="60" width="120">
            </a>
          </div>
          <h4 class="mb-1">Two Step Verification 💬</h4>
          <p class="text-start mb-6">
            We sent a verification code to your email.
          </p>
          <p class="mb-0">Type your 6 digit security code</p>
          <div class="mb-4">
            <div class="auth-input-wrapper d-flex align-items-center justify-content-between numeral-mask-wrapper">
              <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2" maxlength="1" autofocus />
              <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2" maxlength="1" />
              <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2" maxlength="1" />
              <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2" maxlength="1" />
              <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2" maxlength="1" />
              <input type="tel" class="form-control auth-input h-px-50 text-center numeral-mask mx-sm-1 my-2" maxlength="1" />
            </div>
            <input type="hidden" name="otp" />
          </div>

          <button class="btn btn-primary d-grid w-100 mb-3" id="btnVerifyOtp">Verify my account</button>

          <!-- Resend OTP Button with Countdown -->
          <button class="btn btn-outline-secondary d-grid w-100" id="btnResendOtp" disabled>
            Resend OTP in <span id="countdown">120</span>s
          </button>

        </div>
      </div>
    </div>
  </div>
  <!-- / Content -->

  <!-- Core JS -->
  <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../../assets/vendor/libs/popper/popper.js"></script>
  <script src="../../assets/vendor/js/bootstrap.js"></script>
  <script src="../../assets/vendor/libs/node-waves/node-waves.js"></script>
  <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
  <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
  <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
  <script src="../../assets/vendor/js/menu.js"></script>
  <script src="../../assets/vendor/libs/cleavejs/cleave.js"></script>
  <script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
  <script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
  <script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>
  <script src="../../assets/js/main.js"></script>
  <script src="https://cdn.rawgit.com/craftpip/jquery-confirm/master/dist/jquery-confirm.min.js"></script>
  <script src="../../assets/js/pages-auth.js"></script>
  <script src="../../assets/js/pages-auth-two-steps.js"></script>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  @include('source.inlcude.loader')
  <script src="../../pages-custom-js/login-per.js?v=<?= date('His') ?>"></script>

  <!-- Countdown Script -->
  <script>
    $(document).ready(function () {
      let countdown = 120;
      const countdownElement = $('#countdown');
      const resendButton = $('#btnResendOtp');

      let timer = setInterval(() => {
        countdown--;
        countdownElement.text(countdown);
        if (countdown <= 0) {
          clearInterval(timer);
          resendButton.prop('disabled', false);
          resendButton.text('Resend OTP');
        }
      }, 1000);

      resendButton.on('click', function () {
        // Disable again and reset
        $(this).prop('disabled', true);
        countdown = 120;
        $(this).html('Resend OTP in <span id="countdown">120</span>s');

        // Restart the timer
        timer = setInterval(() => {
          countdown--;
          $('#countdown').text(countdown);
          if (countdown <= 0) {
            clearInterval(timer);
            resendButton.prop('disabled', false);
            resendButton.text('Resend OTP');
          }
        }, 1000);

        // Optional: AJAX to resend OTP
        // $.post('/resend-otp', { email: $('#txtEmail').val() }, function(response) {
        //   $.alert('OTP resent to your email.');
        // });
      });
    });
  </script>

</body>

</html>
