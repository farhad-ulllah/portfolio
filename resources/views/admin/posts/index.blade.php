@extends('layouts.admin')
@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Post </h1>


        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#myModal">Add
                    Post</button>
                <h6 class="m-0 font-weight-bold text-primary">Posts </h6>

            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="myTable" class="display">
                        <thead>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Descriptiom</th>
                            <th>Image</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            <!-- Table rows -->
                        </tbody>
                    </table>


                </div>

            </div>
        </div>

    </div>

    <!-- /.container-fluid -->


    <!-- /Add Post modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Post</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="create-post-form">
                        @csrf
                        <div class="row">
                            <div class="mb-12 col-12">
                                <label class="form-label" for="validationCustom01">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Title"
                                    required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-12 col-12">
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
                            <div class="mb-12 col-12">
                                <label class="form-label" for="validationCustom01">Image</label>
                                <input type="file" name="photo" accept="image/*" class="form-control" id="enImg">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <br><br><br>
                            <div class="mb-12 col-12">
                                <label class="form-label" for="validationCustom01">Description</label>
                                <textarea name="description" class="editor" id="description" cols="60" rows="5"></textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="reset" class="btn btn-default">Clear</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Add Post Model --}}

    {{-- Edit Model --}}
    <div id="EditModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Post</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
                    <form id="edit-post-form" class="ps-3 pe-3">
                        @csrf
                        <input type="text" name="post_id" hidden id="post-id">
                        <div class="row">
                            <div class="mb-12 col-12">
                                <label class="form-label" for="validationCustom01">Title</label>
                                <input type="text" class="form-control" name="title" id="post-title_edit"
                                    placeholder="Title" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-12 col-12">
                                <label class="form-label" for="slider_type">Select Category</label>
                                <select name="category_id" id="category_edit" required class="form-control">
                                    <option value="" selected disabled>Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->key }}">{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-12 col-12">
                                <label class="form-label" for="validationCustom01">Image</label>
                                <input type="text" hidden class="form-control" id="image" name="old_image">
                                <input type="file" name="photo" accept="image/*" class="form-control"
                                    id="enImg">
                                <img src="" height="50px" id="my_image" width="50px" alt=""
                                    title="">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <br><br><br>
                            <div class="mb-12 col-12">
                                <label class="form-label" for="validationCustom01">Description</label>
                                <textarea name="description" class="editor" id="post-edit_description" cols="60" rows="5"></textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" id="update-post-btn">Save</button>
                            <button type="reset" class="btn btn-default">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end Edit modal-->
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                serverSide: true,
                ajax: "{{ route('admin.data-table') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            var imageUrl = "{{ asset('storage/posts') }}/" + data;

                            if (data) {
                                return '<img src="' + imageUrl + '" alt="Image" height="50">';
                            } else {
                                var defaultImageUrl = "{{ asset('storage/posts/no_image.jpg') }}";
                                return '<img src="' + defaultImageUrl +
                                    '" alt="Image" height="50">';
                            }
                        }
                    },
                    {
                        data: 'id',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            var editUrl = "{{ route('admin.posts.edit', ':id') }}".replace(':id',
                                data);
                            var deleteUrl = "{{ route('admin.posts.destroy', ':id') }}".replace(
                                ':id', data);

                            return '<a href="#" class="btn btn-primary edit-post-btn" data-id="' +
                                data +
                                '"><i class="fas fa-edit"></i></a>&nbsp;' +
                                '<form action="' + deleteUrl +
                                '" method="post" style="display:inline">' +
                                '@csrf' +
                                '@method('DELETE')' +
                                '<button type="submit" onclick="confirmDelete(event)" ' +
                                'class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>' +
                                '</form>';

                        }
                    }
                ]
            });
        });

        function confirmDelete(event) {
            event.preventDefault(); // Prevent the form from submitting immediately
            if (confirm('Are you sure to delete this?')) {
                var form = event.target.closest('form');
                // Use AJAX to submit the form
                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: $(form).serialize(),
                    success: function(response) {
                        toastr.success('Post deleted successfully.');
                        $('#myTable').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Error deleting post.');
                        // Handle any error during deletion
                    }
                });
            }
        }
        // For Post Created
        $("#create-post-form").on('submit', function(event) {
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
                        $('#myModal').modal('hide');
                        $('#myTable').DataTable().ajax.reload();
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
        $(document).on('click', '.edit-post-btn', function() {
            var postId = $(this).data('id');
            var editUrl = "{{ route('admin.posts.edit', ':id') }}".replace(':id', postId);

            // Fetch the post data using AJAX
            $.ajax({
                url: editUrl,
                method: 'GET',
                success: function(response) {
                    // Populate the form fields with the retrieved data
                    console.log(response.posts);
                    $('#post-id').val(response.posts.id);
                    $('#post-title_edit').val(response.posts.title);
                    $('#post-edit_description').val(response.posts.description);
                    $('#category_edit').val(response.posts.category_id).trigger('change');
                    $('#image').val(response.posts.image);
                    $('#slider_image').val(response.posts.image);
                    image = response.posts.image;
                    var source = "{!! asset('storage/posts/"+image+"') !!}";
                    $('#my_image').attr('src', source);
                    // Show the edit modal
                    $('#EditModal').modal('show');
                },
                error: function(xhr, status, error) {
                    toastr.error('Error fetching post data.');
                }
            });
        });
        //Update The Post 
        // Add an event handler for the update button in the edit modal
        $(document).on('submit', '#edit-post-form', function(event) {
            event.preventDefault();
            var updateUrl = "{{ route('admin.posts_update') }}"; // Replace with your update route URL
            var postId = $('#post-id').val(); // Get the post ID from the hidden input field
            var formData = new FormData($('#edit-post-form')[0]); // Get the form data
            // Append the post ID to the update URL
            // updateUrl = updateUrl.replace(':id', postId);

            // Send an AJAX request to update the record
            $.ajax({
                url: updateUrl,
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 'success') {
                        toastr.success(response.message);
                        // Close the edit modal
                        $('#EditModal').modal('hide');
                        // // Reload the table data
                        $('#myTable').DataTable().ajax.reload();
                    }

                },
                error: function(xhr, status, error) {
                    toastr.error('Error updating post.');
                }
            });
        });
    </script>
@endsection
