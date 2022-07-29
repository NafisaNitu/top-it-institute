@extends('layouts.layout')
@section('title')
    Widget - About
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
                        <h1><i class="nav-icon fas fa-shopping-cart"></i> Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex justify-content-end">
                            <a href="{{route('admin.create.product')}}" class="btn btn-primary" ><i class="fa fa-plus-circle mr-1"></i> Add New Produce</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-md-12">

                        <div class="card card-primary card-outline mb-0">
                            <div class="card-header">
                                <h3 class="card-title text-bold">Product List</h3>
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
                                    @foreach($products as $key => $product)
                                        <tr>
                                            <td>{{ $key+ $products->firstItem() }}</td>
                                            <td>{{$product->title}}</td>
                                            <td>{{ Str::limit($product->sub_title, 30) }}</td>
                                            <td>
                                                @if($product->status=='1')
                                                    Published
                                                @else
                                                    Private
                                                @endif
                                            </td>
                                            <td>
                                                <a class="test-popup-link" href="{{!empty($product->image)?asset('storage/'.$product->image):asset('admin/photos/none.svg')}}">
                                                    <img style="height: 30px" src="{{!empty($product->image)?asset('storage/'.$product->image):asset('admin/photos/none.svg')}}" alt="image">
                                                </a>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{route('admin.edit.product',['id'=>$product->id])}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                    <button onclick="destroyProduct({{$product->id}})" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                                </div>
                                                <form action="{{route('admin.destroy.product',$product->id)}}" style="display: none" id="destroyProduct{{$product->id}}" method="post">@csrf @method('delete') </form>
                                            </td>
                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer d-flex justify-content-end">
                                {{$products->links()}}
                            </div>

                        </div>
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
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.2/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.9.2/dist/js/uikit-icons.min.js"></script>
@endsection

@push('scripts')

    <script>
        function destroyProduct($id) {
            event.preventDefault();
            UIkit.modal.confirm('Are you sure to delete this product!').then(
                function () {
                    document.getElementById('destroyProduct'+$id).submit();
                },
                function () {
                    console.log('Rejected.')
                }
            );
        }
    </script>
@endpush
