@extends('layouts.layout')
@section('title')
    Widget - Subject
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
                        <h1><i class="nav-icon fas fa-user-cog"></i> Subjects</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title text-bold">{{isset($subject)? 'Update':'Add New' }} Service</h3>
                            </div>

                            @if(isset($subject))
                                <form action="{{route('admin.update.subject',$subject->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                                    @else
                                        <form action="{{route('admin.create.subject')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        @endif

                                        <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="form-group row">
                                                    <div class="col-md-4">
                                                        <input name="title" class="form-control" value="{{!empty($subject)?$subject->title:''}}" placeholder="Title">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <select class="form-control menu" name="menu_id" id="menuId">
                                                            <option></option>
                                                            @foreach($menus as $menu)
                                                                <option value="{{$menu->id}}"
                                                                @if(!empty($subject))
                                                                    {{$subject->menu_id == $menu->id ? 'selected' :'' }}
                                                                    @endif
                                                                >{{$menu->menu_name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class=" col-md-12">
                                                        <input name="sub_title" class="form-control" value="{{!empty($subject)?$subject->title:''}}" placeholder="Sub Title">
                                                    </div>
                                                </div>
                                                <div class="form-group" >
                                                    <textarea id="description" name="description" >{{!empty($subject)?$subject->description:''}}</textarea>
                                                </div>
                                                <div class="form-group row">
                                                    <div class=" col-md-12">
                                                        <input name="total_class" class="form-control" value="{{!empty($subject)?$subject->total_class:''}}" placeholder="Sub Title">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class=" col-md-12">
                                                        <input name="total_hour" class="form-control" value="{{!empty($subject)?$subject->total_hour:''}}" placeholder="Total Hours">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class=" col-md-12">
                                                        <input name="fee" class="form-control" value="{{!empty($subject)?$subject->fee:''}}" placeholder="Fee">
                                                    </div>
                                                </div>
                                                @if(!empty($subject))
                                                    <div class="form-group">
                                                        <img style="width: 200px" src="{{!empty($subject->image)?asset('storage/'.$subject->image):asset('admin/photos/none.svg')}}" alt="image">
                                                    </div>
                                                @endif

                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <div class="input-group ">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text" >Image</span>
                                                            </div>
                                                            <div class="custom-file">
                                                                <input type="file" name="image" accept="image/*" class="custom-file-input" id="image">
                                                                <label class="custom-file-label imageName" for="image">Choose file</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mt-2 col-md-6 ">
                                                        <label class="form-label mr-2">{{'Status :' }}</label>
                                                        <div class="form-check form-check-inline ">
                                                            <input type="checkbox" class="form-check-input" {{!empty($subject)?$subject->status==1?'checked':'':''}} name="status" value="1" id="defaultCheck2">
                                                            <label class="form-check-label" for="defaultCheck2">Public</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div id="frames"></div>
                                                </div>
                                            </div>
                                            <!-- /.card-body -->
                                            <div class="card-footer d-flex justify-content-end">
                                                <div class="float-left ">
                                                    <a href="{{route('admin.subjects')}}" class="btn btn-primary ml-2"><i class="fa fa-arrow-left mr-1"></i>Back</a>
                                                </div>
                                                <div class="d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-success ml-2"><i class="fa fa-save mr-1"></i>{{isset($subject)?'Update':'Create'}}</button>
                                                </div>

                                            </div>
                                        </form>

                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection

@section('script-link')
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            $('#image').change(function(){
                $("#frames").html('');
                var fileName = $(this).val();
                if (fileName != undefined || fileName != "") {
                    fileName = fileName.replace("C:\\fakepath\\", "");
                    $(this).next(".imageName").attr('data-content', fileName);
                    $(this).next(".imageName").text(fileName);
                }
                if(fileName == ""){
                    fileName = 'Choose file';
                    $(this).next(".imageName").attr('data-content', fileName);
                    $(this).next(".imageName").text(fileName);
                }
                if(this.files[0]){
                    $("#frames").append('<img src="'+window.URL.createObjectURL(this.files[0])+'" width="200px"/>');
                }
            });
        });

    </script>

    <script>

        @if(isset($subject))
        @if($subject->submenu_id)
        @else
        @if(isset($submenus))
        @else
        $('#submenuId').attr('disabled','disabled');
        @endif
        @endif
        @else
        $('#submenuId').attr('disabled','disabled');
        @endif

        $('#menuId').on('change',function(){
            var id = $(this).val();
            if(id != ''){
                $('#submenuId').empty();
                $.ajax({
                    type:'GET',
                    url:'{{url('/admin/ajax-submenu/')}}/'+id,
                    dataType:"json",
                    success:function (res) {
                        $('#submenuId').removeAttr('disabled');
                        $('#submenuId').append('<option value=""></option>');
                        $.each(res, function (key,value) {
                            $('#submenuId').append('<option value="'+value.id+'">'+value.name+'</option>');
                        })
                    }
                });
            } else {
                $('#submenuId').empty();
                $('#submenuId').attr('disabled','disabled');
            }
        });
    </script>

    <script>
        //Initialize Select2 Elements
        $('.menu').select2({
            allowClear: true,
            placeholder: "Select Menu",
        });
        $('.sub-menu').select2({
            allowClear: true,
            placeholder: "Select Submenu",
        });
        CKEDITOR.replace( 'description' );
    </script>
@endpush



