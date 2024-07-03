<nav class="sidebar" data-trigger="scrollbar">
    <!-- Sidebar Header -->
    <div class="sidebar-header d-none d-lg-block">
        <!-- Sidebar Toggle Pin Button -->
        <div class="sidebar-toogle-pin">
            <i class="icofont-tack-pin"></i>
        </div>
        <!-- End Sidebar Toggle Pin Button -->
    </div>
    <!-- End Sidebar Header -->
    <!-- Sidebar Body -->
    <div class="sidebar-body">
        <!-- Nav -->
        <ul class="nav">
            <li class="{{ request()->is("admin") ? "active" : "" }}">
                <a href="{{ route('admin.home') }}">
                    <i class="icofont-pie-chart"></i>
                    <span class="link-title">الرئيسية</span>
                </a>
            </li>

            @can('owner_managment_access')
                <li class="nav-category">إدارة الاملاك العقارية</li>

                <li class="{{ request()->is("admin/owners*") ? "sub-menu-opened active" : "" }} {{ request()->is("admin/buildings*") ? "sub-menu-opened active" : "" }}">
                    <a href="#">
                        <i class="icofont-building-alt"></i>
                        <span class="link-title">إدارة الاملاك</span>
                    </a>
                    <!-- Sub Menu -->
                    <ul class="nav sub-menu">
                        @can('owner_access')
                            <li class="{{ request()->is("admin/owners*") ? "active" : "" }}">
                                <a href="{{ route('admin.owners.index') }}"> الملاك</a>
                            </li>
                        @endcan
                        @can('building_access')
                            <li class="{{ request()->is("admin/buildings*") ? "active" : "" }}">
                                <a href="{{ route('admin.buildings.index') }}"> العقارات</a>
                            </li>
                        @endcan
                    </ul>
                    <!-- End Sub Menu -->
                </li>
            @endcan

            @can('general_setting_access')
                <li class="nav-category">إدارة النظام</li>

                <li class="{{ request()->is("admin/users*") || request()->is("admin/roles*") || request()->is("admin/countries*") || request()->is("admin/cities*") || request()->is("admin/user-alerts*") ? "sub-menu-opened active" : "" }}">
                    <a href="#">
                        <i class="icofont-settings-alt"></i>
                        <span class="link-title">
                            إدارة النظام
                        </span>
                    </a>
                    <!-- Sub Menu -->
                    <ul class="nav sub-menu">
                        @can('user_access')
                            <li class="{{ request()->is("admin/users*") ? "active" : "" }}">
                                <a href="{{ route('admin.users.index') }}">
                                    المستخدمين</a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="{{ request()->is("admin/roles*") ? "active" : "" }}">
                                <a href="{{ route('admin.roles.index') }}">
                                    الصلاحيات</a>
                            </li>
                        @endcan
                        @can('country_access')
                            <li class="{{ request()->is("admin/countries*") ? "active" : "" }}">
                                <a href="{{ route('admin.countries.index') }}">
                                    الدول</a>
                            </li>
                        @endcan
                        @can('city_access')
                            <li class="{{ request()->is("admin/cities*") ? "active" : "" }}">
                                <a href="{{ route('admin.cities.index') }}">
                                    المدن</a>
                            </li>
                        @endcan
                        @can('user_alert_access')
                            <li class="{{ request()->is("admin/user-alerts*") ? "active" : "" }}">
                                <a href="{{ route('admin.user-alerts.index') }}">
                                    أشعارات المستخدمين</a>
                            </li>
                        @endcan
                    </ul>
                    <!-- End Sub Menu -->
                </li> 
            @endcan

            @can('system_report_access')
                <li class="nav-category">التقارير</li>
                <li>
                    <a href="{{ route('admin.report-buildings.index') }}">
                        <i class="icofont-chart-pie-alt"></i> 
                        <span class="link-title">تقارير العقارات</span>
                    </a>
                </li> 
            @endcan

            <li>
                <hr />
            </li>
            @can('profile_password_edit')
                <li>
                    <a href="{{ route('profile.password.edit') }}">
                        <i class="icofont-user"></i>
                        <span class="link-title">تفاصيل الحساب</span>
                    </a>
                </li>
            @endcan
        </ul>
        <!-- End Nav -->
    </div>
    <!-- End Sidebar Body -->
</nav>
