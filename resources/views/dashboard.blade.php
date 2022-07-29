@extends('layouts.layout')
@section('title')
    Dashboard
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-tachometer-alt"></i> Dashboard</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="icon">
                                <i class=" fa fa-file"></i>
                            </div>
                            <div class="inner">
                                {{--                                <h3>150</h3>--}}
                                <p>Courses</p>
                            </div>
                            <a href="#" class=" small-box-footer" >Show <i class="float-right fa fa-chevron-circle-right mt-1"></i></a>
                            <a href="#" class=" small-box-footer" >Add <i class="float-right fa fa-plus-circle mt-1"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="icon">
                                <i class=" fa fa-sitemap"></i>
                            </div>
                            <div class="inner">
                                {{--                                <h3>53</h3>--}}
                                <p>Subjects</p>
                            </div>
                            <a href="{{route('admin.menus')}}" class=" small-box-footer" >Show <i class="float-right fa fa-chevron-circle-right mt-1"></i></a>
                            <a href="{{route('admin.create.menu')}}" class=" small-box-footer" >Add <i class="float-right fa fa-plus-circle mt-1"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="icon">
                                <i class=" fa fa-camera"></i>
                            </div>
                            <div class="inner">
                                {{--                                <h3>44</h3>--}}
                                <p>Students</p>
                            </div>
                            <a href="{{route('admin.sliders')}}" class=" small-box-footer" >Show <i class="float-right fa fa-chevron-circle-right mt-1"></i></a>
                            <a href="{{route('admin.sliders')}}" class=" small-box-footer" >Add <i class="float-right fa fa-plus-circle mt-1"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="inner">
                                {{--                                <h3>65</h3>--}}
                                <p>Blogs</p>
                            </div>
                            <a href="{{route('admin.blogs')}}" class=" small-box-footer" >Show <i class="float-right fa fa-chevron-circle-right mt-1"></i></a>
                            <a href="{{route('admin.create.blog')}}" class=" small-box-footer" >Add <i class="float-right fa fa-plus-circle mt-1"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>


                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-teal">
                            <div class="icon">
                                <i class=" fa fa-image"></i>
                            </div>
                            <div class="inner">
                                {{--                                <h3>150</h3>--}}
                                <p>Technologies</p>
                            </div>
                            <a href="{{route('admin.medias')}}" class=" small-box-footer" >Show <i class="float-right fa fa-chevron-circle-right mt-1"></i></a>
                            <a href="{{route('admin.create.media')}}" class=" small-box-footer" >Add <i class="float-right fa fa-plus-circle mt-1"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-maroon">
                            <div class="icon">
                                <i class=" fa fa-user-cog"></i>
                            </div>
                            <div class="inner">
                                {{--                                <h3>53</h3>--}}
                                <p>Services</p>
                            </div>
                            <a href="{{route('admin.services')}}" class=" small-box-footer" >Show <i class="float-right fa fa-chevron-circle-right mt-1"></i></a>
                            <a href="{{route('admin.create.service')}}" class=" small-box-footer" >Add <i class="float-right fa fa-plus-circle mt-1"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-purple">
                            <div class="icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                            <div class="inner">
                                {{--                                <h3>44</h3>--}}
                                <p>Teachers</p>
                            </div>
                            <a href="{{route('admin.products')}}" class=" small-box-footer" >Show <i class="float-right fa fa-chevron-circle-right mt-1"></i></a>
                            <a href="{{route('admin.create.product')}}" class=" small-box-footer" >Add <i class="float-right fa fa-plus-circle mt-1"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="icon">
                                <i class=" fa fa-thumbtack "></i>
                            </div>
                            <div class="inner">
                                {{--                                <h3>65</h3>--}}
                                <p>Seminar</p>
                            </div>
                            <a href="{{route('admin.blogs')}}" class=" small-box-footer" >Show <i class="float-right fa fa-chevron-circle-right mt-1"></i></a>
                            <a href="{{route('admin.create.blog')}}" class=" small-box-footer" >Add <i class="float-right fa fa-plus-circle mt-1"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
            </div>
        </section>

        <!-- /.content -->
    </div>
@endsection
