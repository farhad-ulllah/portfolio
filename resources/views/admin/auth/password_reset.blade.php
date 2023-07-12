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
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Update Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user" id="update-password-form">
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Your New Password...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Confirm Password...">
                                        </div>
                                        <input type="hidden" name="token" id="" hidden value="{{ $token }}">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Update Password
                                        </button>
                                    </form>
                                    <hr><h4>{{ $token }}</h4>

                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="login.html">Already have an account? Login!</a>
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
        // Add a submit event handler to the form
        $("#update-password-form").submit(function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();
            // Send an AJAX request to the Laravel controller
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Handle login form submission
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
            $.ajax({
                url: '{{ route('save.password') }}',
                method: "POST",
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(response) {
                    // Show the success message
                    if (response.status === 'success') {
                        toastr.success(response.msg);
                    } else {
                        toastr.error(response.msg);
                    }
                },
                error: function(xhr, status, error) {
                    toastr.error(response.msg);
                }
            });
        });
    </script>
</body>
@endsection
