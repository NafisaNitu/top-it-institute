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
                        <h1><i class="nav-icon fas fa-sitemap "></i> Menus</h1>
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
                                <h3 class="card-title">{{isset($getMenu)?'Update':'Add New'}} Menu</h3>
                            </div>

                            <div class="card-body box-profile">
                                @if(isset($getMenu))
                                    <form method="post" action="{{route('admin.update.menu',['id'=>$getMenu->id])}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="form-group">
                                            <select class="form-control main-menu" name="main_menu" >
                                                <option></option>
                                                <option {{ $getMenu->main_menu == 'product'?'selected':'' }} value="product">Product</option>
                                                <option {{ $getMenu->main_menu == 'service'?'selected':'' }} value="service">Service</option>
                                            </select>
                                        </div>
                                        <div class="form-group ">
                                            <input type="text" name="menu_name" class="form-control"  value="{{$getMenu->menu_name}}" placeholder="Menu Name" >
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
                                            <label class="form-label mr-2">{{'Status :' }}</label>
                                            <div class="form-check form-check-inline ">
                                                <input type="checkbox" class="form-check-input" name="status" {{$getMenu->status=='1'?'checked':''}} value="1" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">Public</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block"><b>Update Menu</b></button>
                                    </form>
                                @else
                                <form method="post" action="{{route('admin.create.menu')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <select class="form-control main-menu" name="main_menu" >
                                            <option></option>
{{--                                            <option value="product">Product</option>--}}
                                            <option value="service">Service</option>
                                        </select>
                                    </div>
                                    <div class="form-group ">
                                        <input type="text" name="menu_name" class="form-control" placeholder="Menu Name" >
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
                                        <label class="form-label mr-2">{{'Status :' }}</label>
                                        <div class="form-check form-check-inline ">
                                            <input type="checkbox" class="form-check-input" name="status" value="1" id="defaultCheck1">
                                            <label class="form-check-label" for="defaultCheck1">Public</label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block"><b>Add Menu</b></button>
                                </form>
                                @endif
                            </div>
                        </div>

                        <!-- /.card -->
                    </div>

                    <div class="col-md-9">
                        <div class="card" x-data="{ currentTab: $persist('menus')}">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li @click.prevent="currentTab = 'menus'" class="nav-item">
                                        <a class="nav-link" :class="currentTab == 'menus' ? 'active' : ''" href="#menus" data-toggle="tab">Menus</a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body p-0">
                                <div class="tab-content">
                                    <div class="tab-pane" :class="currentTab == 'menus' ? 'active' : ''" id="menus">
                                        <div class="card card-primary card-outline mb-0">
                                            <div class="card-header">
                                                <h3 class="card-title">Menu List</h3>
                                            </div>
                                            <!-- /.card-header -->
                                            <div class="card-body table-responsive p-0">
                                                <table class="table table-hover text-nowrap" >
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Menu Name</th>
                                                            <th>Parent Menu</th>
                                                            <th>Status</th>
                                                            <th>Image</th>
                                                            <th class="">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($menus as $key=> $menu)
                                                        <tr>
                                                            <td>{{ $key+ $menus->firstItem() }}</td>
                                                            <td>{{$menu->menu_name}}</td>
                                                            <td>{{ucfirst($menu->main_menu)}}</td>
                                                            <td>
                                                                @if($menu->status=='1')
                                                                    Published
                                                                @else
                                                                    Private
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <a class="test-popup-link" href="{{!empty($menu->image)?asset('storage/'.$menu->image):asset('admin/photos/none.svg')}}">
                                                                    <img style="height: 30px" src="{{!empty($menu->image)?asset('storage/'.$menu->image):asset('admin/photos/none.svg')}}" alt="image">
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <div class="btn-group btn-group-sm">
                                                                    <a href="{{route('admin.edit.menu',['id'=>$menu->id])}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                                    <button onclick="destroyMenu({{$menu->id}})" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                                </div>
                                                                <form action="{{route('admin.destroy.menu',['id'=>$menu->id])}}" style="display: none" id="deleteMenu{{$menu->id}}" method="post">@csrf @method('delete') </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="card-footer d-flex justify-content-end">
                                                {{$menus->links()}}
                                            </div>

                                        </div>

                                    </div>
                                    <!-- /.tab-pane -->


                                    <!-- /.tab-pane -->
                                </div>
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
        $('#exampleMenuImage').on('change',function(){
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
