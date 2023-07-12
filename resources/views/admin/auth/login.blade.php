@extends('layouts.guest')

@section('content')
<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" id="loginForm">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" name="password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('forgot-password') }}">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Handle login form submission
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
            $('#loginForm').on('submit', function(event) {
                event.preventDefault();

                // Get form data
                var formData = $(this).serialize();

                // Send login request
                $.ajax({
                    url: '/admin/login',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log(response);
                        // Handle success response
                        if (response.status === 'success') {
                            window.location.href = "{{ route('admin.dashboard') }}";
                    } else if (response.status === 'fail') {
                        toastr.error(response.message);
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
        });
    </script>
</body>
@endsection
