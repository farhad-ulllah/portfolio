@extends('admin/layouts/layout')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascipt: void(0);">Home</a></li>
                        <li class="breadcrumb-item active">Posts Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Posts Category</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#faq-modal"
                                class="btn btn-danger mb-2"><i class="mdi mdi-plus-circle me-2"></i> Add Category</a>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-end">
                                <button type="button" class="btn btn-success mb-2 me-1"><i
                                        class="mdi mdi-cog-outline"></i></button>
                                <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                <button type="button" class="btn btn-light mb-2">Export</button>
                            </div>
                        </div><!-- end col-->
                    </div>
                    <table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Namedf</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $category->name}}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="edit action-icon"
                                            data-category="{{ $category }}" data-bs-toggle="modal"
                                            data-bs-target="#editModel" data-id="{{ $category->id }}"> <i
                                                class="mdi mdi-square-edit-outline"></i></a>
                                        <form action="{{ route('admin.post_category.destroy', $category->id) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure to delete this?')"
                                                class="action-icon" style="border: none"> <i
                                                    class="mdi mdi-delete"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>
    {{-- ModAL  --}}
    <div id="faq-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="faq-modalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="standard-modalLabel"> Add Category </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" action="{{ route('admin.post_category.store') }}" id="form"
                        method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label class="form-label" for="validationCustom01">Title</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name"
                                    required>
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
                                <button type="submit" id="submit-btn" class="btn btn-primary"> Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!--Edit  Modal -->
    <div class="modal fade" id="editModel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div> <!-- end modal header -->
                <div class="modal-body">
                    <form action="{{ route('admin.post_category_update') }}" enctype="multipart/form-data" method="POST"
                        class="ps-3 pe-3">
                        @csrf
                        <input type="text" hidden name="category_id" id="category_id">
                        <div class="row">
                            <div class="mb-3 col-12">
                                <label class="form-label" for="validationCustom01">Title</label>
                                <input type="text" class="form-control" name="name" id="title"
                                    placeholder="Name" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="mb-3 col-12">
                                <label class="form-label" for="validationCustom01">Description</label>
                                <textarea name="description" class="editor" id="des" cols="30" rows="10"></textarea>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <input type="submit" class="btn btn-primary" value="Add">
                            </div> <!-- end modal footer -->
                    </form>
                </div> <!-- end modal content-->
            </div> <!-- end modal dialog-->
        </div> <!-- end Edit modal-->
    @endsection
    @section('scripts')
        <script>
            $(document).on('click', '.edit', function(e) {
                e.preventDefault();
                var category = $(this).data('category');
                $('#title').val(category.name);
                $('#category_id').val(category.id);
                CKEDITOR.replace('des');
         CKEDITOR.instances['des'].setData(category.description);
            })
        </script>
    @endsection
