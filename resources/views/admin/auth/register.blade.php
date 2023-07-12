@extends('layouts.guest')

@section('content')
<body class="bg-gradient-primary">

    <div class="container">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
              <div class="p-5">
                <div class="text-center">
                  <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                </div>
                <form class="user" id="create-record-form">
                    @csrf
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <input type="text" name="first_name" class="form-control form-control-user" id="fname" placeholder="First Name">
                      <span class="invalid-feedback" id="first_name" role="alert" style="color:red">
                        <strong></strong>
                    </span>
                    </div>
                    <div class="col-sm-6">
                      <input type="text" name="last_name" class="form-control form-control-user" id="lname" placeholder="Last Name">
                      <span class="invalid-feedback" id="last_name" role="alert" style="color:red">
                        <strong></strong>
                    </span>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Email Address">
                    <span class="invalid-feedback" id="email" role="alert" style="color:red">
                        <strong></strong>
                    </span>
                </div>
                  <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                      <input type="password" name="password" class="form-control form-control-user" id="password" placeholder="Password">
                      <span class="invalid-feedback" id="password" role="alert" style="color:red">
                        <strong></strong>
                    </span>
                    </div>
                    <div class="col-sm-6">
                      <input type="password" name="password_confirmation" class="form-control form-control-user" id="confPassword" placeholder="Repeat Password">
                      <span class="invalid-feedback" id="confirm_password" role="alert" style="color:red">
                        <strong></strong>
                    </span>
                    </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-user btn-block">
                    Register Account
                  </button>
                  <hr>
                  <a href="index.html" class="btn btn-google btn-user btn-block">
                    <i class="fab fa-google fa-fw"></i> Register with Google
                  </a>
                  <a href="index.html" class="btn btn-facebook btn-user btn-block">
                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                  </a>
                </form>
                <hr>
                <div class="text-center">
                  <a class="small" href="forgot-password.html">Forgot Password?</a>
                </div>
                <div class="text-center">
                  <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

    <script>
        // Add a submit event handler to the form
        $("#create-record-form").submit(function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();
                // Send an AJAX request to the Laravel controller
                $.ajax({
                    url: '{{ route('admin.register') }}',
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Show the success alert
                        if (response.message) {
                          toastr.success(response.message);
                             // Redirect to the home route after 3 seconds
                        setTimeout(function() {
                            window.location.href = '{{ route('login') }}';
                        }, 3000);
                        }
                    },
                    error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    if (response && response.errors) {
                        var errors = response.errors;
                        // Remove previous error messages
                        $(".invalid-feedback").removeClass("error-message").html("");
                        $.each(errors, function(field, error) {
                            toastr.error(error[0]);
                            // Find the input field and its corresponding span tag
                            var inputField = $(`input[name="${field}"]`);
                            inputField.siblings(".invalid-feedback").addClass("error-message").html(error[0]);
                        });
                    } else if (response && response.message) {
                        toastr.error(response.message);
                    }
                },

                });
            });
    </script>
    @endsection
