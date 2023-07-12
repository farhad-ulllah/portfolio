@extends('layouts.admin')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Create Post </h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create Posts </h6>

            </div>
            <div class="card-body">
                <form id="create-post-form" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label class="form-label" for="validationCustom01">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Title"
                                required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label" for="slider_type">Select Category</label>

                            <select name="category_id" id="category" required class="form-control">
                                <option value="" selected disabled>Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->key }}">{{ $category->title }}</option>
                                @endforeach
                            </select>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="mb-3 col-6">
                            <label class="form-label" for="validationCustom01">Image</label>
                            <input type="file" name="photo" accept="image/*" class="form-control" id="enImg">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="mb-3 col-12">
                            <label class="form-label" for="validationCustom01">Description</label>
                            <textarea name="description" class="editor" id="description" cols="30" rows="10"></textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="mb-3 text-end">
                            <button type="submit" id="submit-btn" class="btn btn-primary float-right"> Add</button>
                        </div>

                </form>
            </div>
        </div>
        <!-- /.modal -->
    @endsection
    @section('scripts')
        <script>
            $("#create-post-form").submit(function(event) {
                // Prevent the default form submission behavior
                event.preventDefault();
                // Send an AJAX request to the Laravel controller
                $.ajax({
                    url: '{{ route('admin.posts.store') }}',
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        // Show the success alert
                        if (response.message) {
                            toastr.success(response.message);
                            // Redirect to the home route after 3 seconds
                        }
                    },
                    error: function(xhr, status, error) {
                        var response = xhr.responseJSON;
                        if (response && response.errors) {
                            var errors = response.errors;
                            $.each(errors, function(field, error) {
                                toastr.error(error[0]);
                            });
                        } else if (response && response.message) {
                            toastr.error(response.message);
                        }
                    },

                });
            });
        </script>
    @endsection
