@extends('layouts.layout')
@section('title')
    Menus
@endsection

@section('css-link')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.9.2/dist/css/uikit.min.css" />
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-sitemap "></i> Categories</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary ">
                            <div class="card-header">
                                <h3 class="card-title">Category</h3>
                            </div>

                            <div class="card-body box-profile">
                                    <form method="post" action="" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <select class="form-control main-menu" name="main_menu" >
                                                <option></option>
                                                <option value="product">Product</option>
                                                <option value="service">Service</option>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <input type="text" name="category_name" class="form-control"  value="" placeholder="Menu Name" >
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Image</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" name="image" accept="image/*" class="custom-file-input" id="exampleMenuImage">
                                                    <label class="custom-file-label menu-image" for="exampleMenuImage">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ml-1">
                                            <label class="form-label mr-2"></label>
                                            <div class="form-check form-check-inline ">
                                                <input type="checkbox" class="form-check-input" name="status" value="1" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">Public</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block"><b>Update Category</b></button>
                                    </form>

                                    <form method="post" action="" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <select class="form-control main-menu" name="main_menu" >
                                                <option></option>
                                                <option value="product">Product</option>
                                                <option value="service">Service</option>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <input type="text" name="category_name" class="form-control" placeholder="Menu Name" >
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Image</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" name="image" accept="image/*" class="custom-file-input" id="exampleMenuImage">
                                                    <label class="custom-file-label menu-image" for="exampleMenuImage">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ml-1">
                                            <label class="form-label mr-2"></label>
                                            <div class="form-check form-check-inline ">
                                                <input type="checkbox" class="form-check-input" name="status" value="1" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">Public</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block"><b>Add Category</b></button>
                                    </form>

                            </div>
                        </div>

                        <!-- /.card -->
                    </div>

                    <div class="col-md-9">
                        <div class="card" x-data="">
                            <div class="card-body p-0">
                                        <div class="card card-primary mb-0">
                                            <div class="card-header">
                                                <h3 class="card-title">Category List</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap" >
                                                    <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Category Name</th>
                                                        <th>Status</th>
                                                        <th>Image</th>
                                                        <th class="">Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
{{--                                                    @foreach($categories as $key=> $category)--}}
                                                        <tr>
                                                            <td>1</td>
                                                            <td>Web development</td>
                                                            <td>active</td>
                                                            <td>
                                                                <a class="test-popup-link" href="">
                                                                    <img style="height: 30px" src="" alt="image">
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                                    <button class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                                </div>
                                                            </td>
                                                        </tr>
{{--                                                    @endforeach--}}
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-footer d-flex justify-content-end">
{{--                                                {{$menus->links()}}--}}
                                            </div>

                                        </div>

                                    <!-- /.tab-pane -->

                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
@endsection

@section('script-link')
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.2/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.2/dist/js/uikit-icons.min.js"></script>
@endsection

@push('scripts')
    <script>
        $('#exampleM' +
            'enuImage').on('change',function(){
            var fileName = $(this).val();
            fileName = fileName.replace("C:\\fakepath\\", "");
            if (fileName != undefined || fileName != "") {
                $(this).next(".menu-image").attr('data-content', fileName);
                $(this).next(".menu-image").text(fileName);
            }
            if(fileName == ""){
                fileName = 'Choose file';
                $(this).next(".menu-image").attr('data-content', fileName);
                $(this).next(".menu-image").text(fileName);
            }
        })
        $('#exampleSubmenuImage').on('change',function(){
            var fileName = $(this).val();
            fileName = fileName.replace("C:\\fakepath\\", "");
            if (fileName != undefined || fileName != "") {
                $(this).next(".submenu-image").attr('data-content', fileName);
                $(this).next(".submenu-image").text(fileName);
            }
            if(fileName == ""){
                fileName = 'Choose file';
                $(this).next(".submenu-image").attr('data-content', fileName);
                $(this).next(".submenu-image").text(fileName);
            }
        })
    </script>

    <script>
        //Initialize Select2 Elements
        $('.main-menu').select2({
            placeholder: "Select Parent Menu",
        });
        $('.menu').select2({
            placeholder: "Select Menu",
        });
    </script>
    <script>
        function destroySubmenu($id) {
            event.preventDefault();
            UIkit.modal.confirm('Are you sure to delete this submenu !').then(
                function () {
                    document.getElementById('deleteSubMenu'+$id).submit();
                },
                function () {
                    console.log('Rejected.')
                }
            );
        }
        function destroyMenu($id) {
            event.preventDefault();
            UIkit.modal.confirm('Are you sure to delete this menu !').then(
                function () {
                    document.getElementById('deleteMenu'+$id).submit();
                },
                function () {
                    console.log('Rejected.')
                }
            );
        }
    </script>
@endpush
