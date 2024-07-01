<div class="main-header">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <div class="col-3 col-lg-1 col-xl-4">
                <!-- Header Left -->
                <div class="main-header-left h-100 d-flex align-items-center">
                    <!-- Main Header User -->
                    <div class="main-header-user">
                        <a href="#" class="d-flex align-items-center" data-toggle="dropdown">
                            <div class="menu-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>

                            <div class="user-profile d-xl-flex align-items-center d-none">
                                <!-- User Avatar -->
                                <div class="user-avatar">
                                    @php($authUser = auth()->user())
                                    <img src="{{ $authUser->photo ? $authUser->photo->getUrl('preview') : asset('assets/img/avatar/user0.png') }}" alt="" />
                                </div>
                                <!-- End User Avatar -->
                                <!-- User Info -->
                                <div class="user-info">
                                    <h4 class="user-name">
                                        {{ $authUser->fullName }}
                                    </h4>
                                    <p class="user-email">
                                        {{ $authUser->email }}
                                    </p>
                                </div>
                                <!-- End User Info -->
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="{{  route('profile.password.edit') }}">الإعدادات</a>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">تسجيل خروج</a>
                        </div>
                    </div>
                    <!-- End Main Header User -->
                    <!-- Main Header Menu -->
                    <div class="main-header-menu d-block d-lg-none">
                        <div class="header-toogle-menu">
                            <!-- <i class="icofont-navigation-menu"></i> -->
                            <img src="{{ asset('assets/img/menu.png') }}" alt="" />
                        </div>
                    </div>
                    <!-- End Main Header Menu -->
                </div>
                <!-- End Header Left -->
            </div>
            <div class="col-9 col-lg-11 col-xl-8">
                <!-- Header Right -->
                <div class="main-header-right d-flex justify-content-end">
                    <ul class="nav"> 
                        <li class="mysearch-header-nav d-none d-xl-flex">
                            <select class="searchable-field form-control   " placeholder="بحث" > 
                            </select>
                        </li>

                        <li>
                            <!-- Main Header Notification -->
                            <div class="main-header-notification">
                                @php($alertsCount = \Auth::user()->userUserAlerts()->where('read', false)->count())
                                <a href="#" class="header-icon notification-icon" data-toggle="dropdown">
                                    @if($alertsCount > 0)
                                        <span class="count" data-bg-img="{{ asset('assets/img/count-bg.png') }}">{{ $alertsCount }}</span>
                                    @endif
                                    <img src="{{ asset('assets/img/svg/notification-icon.svg') }}" alt=""
                                        class="svg" />
                                </a>
                                <div class="dropdown-menu style--two">
                                    <!-- Dropdown Header -->
                                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                                        <h5>{{ $alertsCount }} إشعارات جديدة</h5> 
                                    </div>
                                    <!-- End Dropdown Header -->
                                    <!-- Dropdown Body -->
                                    <div class="dropdown-body">
                                        <!-- Item Single -->
                                        @if(count($alerts = \Auth::user()->userUserAlerts()->withPivot('read')->limit(10)->orderBy('created_at', 'ASC')->get()->reverse()) > 0)
                                            @foreach($alerts as $alert)
                                                <a href="{{ $alert->alert_link ? $alert->alert_link : "#" }}" class="item-single d-flex align-items-center">
                                                    <div class="content">
                                                        <div class="mb-2">
                                                            <p class="time">
                                                                {{ $alert->created_at }}
                                                            </p>
                                                        </div>
                                                        <p class="main-text">
                                                            @if($alert->pivot->read === 0) <strong> @endif
                                                                {{ $alert->alert_text }}
                                                                @if($alert->pivot->read === 0) </strong> @endif
                                                        </p>
                                                    </div>
                                                </a>
                                            @endforeach
                                        @else 
                                            <a href="#" class="item-single d-flex align-items-center">
                                                <div class="content">
                                                    <div class="mb-2">
                                                        <p class="time"> 
                                                        </p>
                                                    </div>
                                                    <p class="main-text">
                                                        {{ trans('global.no_alerts') }}
                                                    </p>
                                                </div>
                                            </a>
                                        @endif
                                        <!-- End Item Single --> 
                                    </div>
                                    <!-- End Dropdown Body -->
                                </div>
                            </div>
                            <!-- End Main Header Notification -->
                        </li>
                    </ul>
                </div>
                <!-- End Header Right -->
            </div>
        </div>
    </div>
</div>
