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
                        <h1><i class="nav-icon fas fa-sliders-h "></i> Sliders</h1>
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
                                <h3 class="card-title">{{isset($slider)?'Update':'Add New'}} Slider</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                @if(isset($slider))
                                    <form method="post" action="{{route('admin.update.slider',['id'=>$slider->id])}}" enctype="multipart/form-data">
                                        @csrf
                                        @method('put')
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="title" value="{{$slider->title}}" placeholder="Title" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" name="sub_title" value="{{$slider->sub_title}}" placeholder="Sub Title" >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Image</span>
                                                </div>
                                                <div class="custom-file">
                                                    <input type="file" name="image" accept="image/*" class="custom-file-input" id="exampleInputImage">
                                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ml-1">
                                            <label class="form-label mr-2">{{'Status :' }}</label>
                                            <div class="form-check form-check-inline ">
                                                <input type="checkbox" class="form-check-input" {{$slider->status = 1 ? 'checked': '' }} name="status" value="1" id="defaultCheck2">
                                                <label class="form-check-label" for="defaultCheck2">Public</label>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-block"><b>Update Sub Menu</b></button>
                                    </form>
                                @else
                                <form method="post" action="{{route('admin.create.slider')}}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="title" placeholder="Title" >
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="sub_title" placeholder="Sub Title" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Image</span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" name="image" accept="image/*" class="custom-file-input" id="exampleInputImage">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ml-1">
                                        <label class="form-label mr-2">{{'Status :' }}</label>
                                        <div class="form-check form-check-inline ">
                                            <input type="checkbox" class="form-check-input"  name="status" value="1" id="defaultCheck2">
                                            <label class="form-check-label" for="defaultCheck2">Public</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block"><b>Add Sub Menu</b></button>
                                </form>
                                @endif
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                    <div class="col-md-9">
                        <div class="card card-primary card-outline mb-0">
                            <div class="card-header">
                                <h3 class="card-title">Slider List</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap" >
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Sub Title</th>
                                        <th>Status</th>
                                        <th>Image</th>
                                        <th class="">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sliders as $key => $slider)
                                    <tr>
                                        <td>{{ $key+ $sliders->firstItem() }}</td>
                                        <td>{{ Str::limit($slider->title, 10) }}</td>
                                        <td>{{ Str::limit($slider->sub_title, 30) }}</td>
                                        <td>
                                            @if($slider->status=='1')
                                                Published
                                            @else
                                                Private
                                            @endif
                                        </td>
                                        <td>
                                            <a class="test-popup-link" href="{{!empty($slider->image)?asset('storage/'.$slider->image):asset('admin/photos/none.svg')}}">
                                                <img style="height: 30px" src="{{!empty($slider->image)?asset('storage/'.$slider->image):asset('admin/photos/none.svg')}}" alt="image">
                                            </a>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{route('admin.edit.slider',['id'=>$slider->id])}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                <button onclick="destroySlider({{$slider->id}})" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                            </div>
                                            <form action="{{route('admin.destroy.slider',['id'=>$slider->id])}}" style="display: none" id="destroySlider{{$slider->id}}" method="post">@csrf @method('delete') </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                {{$sliders->links()}}
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
        $('#exampleInputImage').on('change',function(){
            var fileName = $(this).val();
            fileName = fileName.replace("C:\\fakepath\\", "");
            if (fileName != undefined || fileName != "") {
                $(this).next(".custom-file-label").attr('data-content', fileName);
                $(this).next(".custom-file-label").text(fileName);
            }
            if(fileName == ""){
                fileName = 'Choose file';
                $(this).next(".custom-file-label").attr('data-content', fileName);
                $(this).next(".custom-file-label").text(fileName);
            }
        })
    </script>




    <script>
        function destroySlider($id) {
            event.preventDefault();
            UIkit.modal.confirm('Are you sure to delete this slider !').then(
                function () {
                    document.getElementById('destroySlider'+$id).submit();
                },
                function () {
                    console.log('Rejected.')
                }
            );
        }
    </script>
@endpush
