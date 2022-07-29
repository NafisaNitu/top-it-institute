@extends('layouts.layout')
@section('title')
    Slideshow
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
                        <h1><i class="nav-icon fas fa-image "></i> Medias</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{'Add New'}} Media</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form method="post" action="{{route('admin.create.media')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="label" placeholder="Label" >
                                        </div>
                                    </div>

                                    <div class="form-group">
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
                                    <button type="submit" class="btn btn-primary btn-block"><b>Add Image</b></button>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-9">
                        <div class="card card-primary card-outline mb-0">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Media List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap" >
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Label</th>
                                        <th class="">Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($medias as $key => $media)
                                        <tr>
                                            <td>{{ $key+ $medias->firstItem() }}</td>
                                            <td>
                                                <a class="test-popup-link" href="{{!empty($media->image)?asset('storage/'.$media->image):asset('admin/photos/none.svg')}}">
                                                    <img style="height: 30px" src="{{!empty($media->image)?asset('storage/'.$media->image):asset('admin/photos/none.svg')}}" alt="image">
                                                </a>
                                            </td>
                                            <td>{{$media->label}}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button onclick="deleteMedia({{$media->id}})" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                </div>
                                                <form action="{{route('admin.destroy.media',['id'=>$media->id])}}" style="display: none" id="deleteMedia{{$media->id}}" method="post">@csrf @method('delete') </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                {{$medias->links()}}
                            </div>

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


        $('#image').change(function(){
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
        });
    </script>

    <script>
        function deleteMedia($id) {
            event.preventDefault();
            UIkit.modal.confirm('Are you sure to delete media!').then(
                function () {
                    document.getElementById('deleteMedia'+$id).submit();
                },
                function () {
                    console.log('Rejected.')
                }
            );
        }
    </script>
@endpush
