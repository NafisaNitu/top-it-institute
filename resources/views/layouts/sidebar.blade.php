<aside class="main-sidebar sidebar-light-green elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link">
        <img src="{{asset('admin/photos/logo.png')}}" alt="Logo" class="brand-image mx-0 " style="opacity: .8;float: none;">
{{--        <span class="brand-text h5 fw-bolder">TopIt</span>--}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item ">
                    <a href="{{route('admin.dashboard')}}" class="nav-link {{ Request::is('admin/dashboard') ? 'active' : null }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item
                {{ Request::is('admin/menu*')||
                    Request::is('admin/sub-menu*')||
                     Request::is('admin/category*')||
                    Request::is('admin/service*')||
                    Request::is('admin/product*')||
                    Request::is('admin/media*')||
                    Request::is('admin/blog*')||
                    Request::is('admin/slider*') ? 'menu-open' : null }}
                ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Modules<i class="fas fa-angle-down right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" >
                        <li class="nav-item ">
                            <a href="{{route('admin.menus')}}" class="nav-link {{ Request::is('admin/menu*')||Request::is('admin/sub-menu*') ? 'active' : null }} pl-4">
                                <i class="fas fa-file nav-icon"></i>
                                <p>Menus</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{route('admin.categories')}}" class="nav-link {{ Request::is('admin/category*') ? 'active' : null }} pl-4">
                                <i class="fas fa-file nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{route('admin.subjects')}}" class="nav-link {{ Request::is('admin/subject*') ? 'active' : null }} pl-4">
                                <i class="fas fa-user nav-icon"></i>
                                <p>Subjects</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{route('admin.services')}}" class="nav-link {{ Request::is('admin/service*') ? 'active' : null }} pl-4">
                                <i class="fas fa-user-cog nav-icon"></i>
                                <p>Services</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{route('admin.products')}}" class="nav-link {{ Request::is('admin/product*') ? 'active' : null }} pl-4">
                                <i class="fas fa-shopping-cart nav-icon"></i>
                                <p>Product</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{route('admin.blogs')}}" class="nav-link {{ Request::is('admin/blog*') ? 'active' : null }} pl-4">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Blogs</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{route('admin.medias')}}" class="nav-link {{ Request::is('admin/media*') ? 'active' : null }} pl-4">
                                <i class="fas fa-image nav-icon"></i>
                                <p>Medias</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{route('admin.sliders')}}" class="nav-link {{ Request::is('admin/slider*') ? 'active' : null }} pl-4">
                                <i class="fas fa-sliders-h nav-icon"></i>
                                <p>Slider</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item
                {{ Request::is('admin/page*') ? 'menu-open' : null }}
                ">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Pages<i class="fas fa-angle-down right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" >
                        <li class="nav-item ">
                            <a href="{{route('admin.about')}}" class="nav-link {{ Request::is('admin/page/about*') ? 'active' : null }} pl-4">
                                <i class="fas fa-font nav-icon"></i>
                                <p>About</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item {{ Request::is('admin/widget*') ? 'menu-open' : null }}">
                    <a href="#" class="nav-link ">
                        <i class="nav-icon fas fa-th-large"></i>
                        <p>Widgets <i class="fas fa-angle-down right"></i></p>
                    </a>
                    <ul class="nav nav-treeview" >
                        <li class="nav-item ">
                            <a href="{{route('admin.widget.about')}}" class="nav-link {{ Request::is('admin/widget-about') ? 'active' : null }} pl-4">
                                <i class="fas fa-font nav-icon"></i>
                                <p>About</p>
                            </a>
                        </li>
                        <li class="nav-item ">
                            <a href="{{route('admin.widget.clients')}}" class="nav-link {{ Request::is('admin/widget-client*') ? 'active' : null }} pl-4">
                                <i class="fas fa-user-astronaut nav-icon"></i>
                                <p>Clients</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item ">
                    <a href="{{url('https://waterchembd.com/')}}" class="nav-link"  target="_blank">
                        <i class="nav-icon fas fa-eye "></i>
                        <p>Preview</p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="{{route('admin.setting')}}" class="nav-link {{ Request::is('admin/setting') ? 'active' : null }}">
                        <i class="nav-icon fas fa-cog "></i>
                        <p>Setting</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
