@extends('layouts.layout')
@section('title')
    About
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
                        <h1><i class="nav-icon fas fa-file-alt"></i> Pages</h1>
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
                                <h3 class="card-title text-bold">About {{isset($about)? 'Update':'' }}</h3>
                            </div>
                            @if(isset($about))
                                <form action="{{route('admin.update.about',['id'=>$about->id])}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @method('put')
                            @else
                                <form action="{{route('admin.create.about')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                            @endif

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <input name="title" class="form-control" value="{{!empty($about)?$about->title:''}}" placeholder="Title">
                                        </div>

                                        <div class="col-md-8">
                                            <input name="sub_title"  class="form-control" value="{{!empty($about)?$about->sub_title:''}}" placeholder="Sub Title">
                                        </div>
                                    </div>

                                    <div class="form-group" >
                                        <textarea id="description" name="description" >{{!empty($about)?$about->description:''}}</textarea>
                                    </div>
                                    @if(!empty($about))
                                        <div class="form-group">
                                            <img style="width: 200px" src="{{!empty($about->image)?asset('storage/'.$about->image):''}}" alt="image">
                                        </div>
                                    @endif
                                    <div class="form-group row">
                                        <div class="input-group col-md-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" >Image</span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" name="image" accept="image/*" class="custom-file-input" id="image">
                                                <label class="custom-file-label imageName" for="image">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="frames"></div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer ">
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-success ml-2"><i class="fa fa-save mr-1"></i>Save</button>
                                    </div>
                                </div>
                            </form>
                            <!-- /.card-footer -->
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
    <script type="text/javascript">
        // initSample();
        CKEDITOR.replace( 'description' );
    </script>
@endpush
