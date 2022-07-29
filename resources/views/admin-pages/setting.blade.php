@extends('layouts.layout')
@section('title')
    Setting
@endsection

@section('css-link')
    <style>
        input::-webkit-outer-spin-button,input::-webkit-inner-spin-button {-webkit-appearance: none;margin: 0;}
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-cog "></i> Setting</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- /.col -->
                    <div class="col-md-12">
                        <div class="card" x-data="{  currentTab: $persist('generalSetting')}">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li @click.prevent="currentTab = 'generalSetting'" class="nav-item">
                                        <a class="nav-link" :class="currentTab == 'generalSetting' ? 'active' : ''" href="#generalSetting" data-toggle="tab">General Setting</a>
                                    </li>
                                    <li @click.prevent="currentTab = 'profile'" class="nav-item">
                                        <a class="nav-link" :class="currentTab == 'profile' ? 'active' : ''" href="#profile" data-toggle="tab">Profile</a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane" :class="currentTab == 'generalSetting' ? 'active' : ''" id="generalSetting">
                                        <form class="form-horizontal" method="post" action="{{ route('admin.general.setting') }}">
                                            @csrf
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <input type="text" name="about" value="{{isset($setting) ? $setting->about :''}}" class="form-control" placeholder="Footer About">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <input type="number" min="0" name="telephone" class="form-control" value="{{isset($setting) ? $setting->telephone :''}}" placeholder="Office Telephone">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="number" min="0" name="mobile" class="form-control" value="{{isset($setting) ? $setting->mobile :''}}"  placeholder="Office Mobile" >
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-6">
                                                    <input type="email" name="email" class="form-control" value="{{isset($setting) ? $setting->email :''}}"  placeholder="Main Email">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="email" name="inquiries_email" class="form-control" value="{{isset($setting) ? $setting->inquiries_email :''}}"  placeholder="Inquiries Email" >
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-4">
                                                    <input type="text" name="facebook" class="form-control" value="{{isset($setting) ? $setting->facebook :''}}"  placeholder="Facebook Link">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" name="linkedin" class="form-control" value="{{isset($setting) ? $setting->linkedin :''}}"  placeholder="Linkedin Link" >
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" name="twitter" class="form-control" value="{{isset($setting) ? $setting->twitter :''}}"  placeholder="Twitter Link" >
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <input type="text" name="address" class="form-control" value="{{isset($setting) ? $setting->address :''}}"  placeholder="Address" >
                                                </div>
                                            </div>

                                            <div class="form-group" >
                                                <label for="description" style="padding-left: 0" class="col-sm-2 col-form-label">Contact full Info</label>
                                                <textarea id="description" name="contact_address" >{{!empty($setting)?$setting->contact_address:''}} </textarea>
                                            </div>

                                            <div class="form-group row">
                                                <div class="offset-sm-12 col-sm-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                    <div class="tab-pane" :class="currentTab == 'profile' ? 'active' : ''" id="profile">
                                        <form class="form-horizontal" method="post" action="{{ route('user-password.update') }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group row">
                                                <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                <div class="col-sm-6">
                                                    <input type="email" class="form-control" id="inputEmail" disabled value="{{auth()->user()->email}}">
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                                                <div class="col-sm-6">
                                                    <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Current Password">
                                                    @if($errors->updatePassword->get('current_password'))
                                                        <div class="text-danger" >{{ $errors->updatePassword->first('current_password') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 col-form-label">Password</label>
                                                <div class="col-sm-6">
                                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                                                    @if($errors->updatePassword->get('password'))
                                                        <div class="text-danger" >{{ $errors->updatePassword->first('password') }}</div>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="password" class="col-sm-2 col-form-label">Confirm Password</label>
                                                <div class="col-sm-6">
                                                    <input type="password" name="password_confirmation" class="form-control" id="confirm_password" placeholder="Confirm Password">
                                                    @if($errors->updatePassword->get('password_confirmation'))
                                                        <div class="text-danger" >{{ $errors->updatePassword->first('password_confirmation') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="offset-sm-2 col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </section>
        <!-- /.content -->

    </div>
@endsection


@section('script-link')
    <script src="https://cdn.ckeditor.com/4.17.1/standard/ckeditor.js"></script>
@endsection

@push('scripts')
    <script>
        CKEDITOR.replace( 'description' );
    </script>
@endpush

