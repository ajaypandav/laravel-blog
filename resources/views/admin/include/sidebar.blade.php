<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="link-effect font-w700" href="{{ url('/admin/dashboard') }}">
                        <span class="font-size-xl text-dual-primary-dark">laravel</span><span class="font-size-xl text-primary">Blog</span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li>
                    <a class="{{ request()->is('admin/dashboard') ? ' active' : '' }}" href="{{ url('/admin/dashboard') }}"><i class="fa fa-tachometer"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                </li>
                <li>
                    <a class="{{ request()->is('admin/category') ? ' active' : '' }}" href="{{ url('/admin/category') }}"><i class="fa fa-th-list"></i><span class="sidebar-mini-hide">Categories</span></a>
                </li>
                <li>
                    <a class="{{ request()->is('admin/blog') ? ' active' : '' }}" href="{{ url('/admin/blog') }}"><i class="fa fa-rss"></i><span class="sidebar-mini-hide">Blog</span></a>
                </li>
                <li>
                    <a class="{{ request()->is('admin/subscriber') ? ' active' : '' }}" href="{{ url('/admin/subscriber') }}"><i class="fa fa-envelope"></i><span class="sidebar-mini-hide">Subscribers</span></a>
                </li>
                <li>
                    <a class="{{ request()->is('admin/contact') ? ' active' : '' }}" href="{{ url('/admin/contact') }}"><i class="fa fa-phone"></i><span class="sidebar-mini-hide">Contacts</span></a>
                </li>
                <li class="{{ request()->is('admin/change-password') || request()->is('admin/config') ? 'open' : '' }}">
                    <a class="nav-submenu " data-toggle="nav-submenu" href="#"><i class="fa fa-cogs"></i><span class="sidebar-mini-hide">Settings</span></a>
                    <ul>
                        <li>
                            <a class="{{ request()->is('admin/config') ? 'active' : '' }}" href="{{ url('/admin/config') }}">System Configuration</a>
                        </li>
                        <li>
                            <a class="{{ request()->is('admin/change-password') ? 'active' : '' }}" href="{{ url('/admin/change-password') }}">Change Password</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>