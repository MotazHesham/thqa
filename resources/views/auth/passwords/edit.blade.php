@extends('layouts.admin')
@section('content')
    <div class="main-content d-flex flex-column flex-md-row">
        <div class="mb-4 mb-md-0">
            <!-- Tasks Aside -->
            <div class="aside">
                <!-- Aside Body -->
                <nav class="aside-body">
                    <h4 class="mb-3">تفاصيل الحساب</h4>

                    <ul class="nav flex-column">
                        <li><a class="active" data-toggle="tab" href="#general">بيانات عامه</a></li>
                        <li><a data-toggle="tab" href="#c_pass">تغيير كلمة المرور</a></li>
                        <li><a data-toggle="tab" href="#info">البيانات الشخصية</a></li>

                        <li><a data-toggle="tab" href="#notifications">الإشعارات</a></li>
                    </ul>
                </nav>
                <!-- End Aside Body -->
            </div>
            <!-- End Tasks Aside -->
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-12 mb-30 mb-xl-0">
                    <!-- Card -->
                    <div class="card h-100">
                        <div class="card-body p-30">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="general">
                                    <h4 class="mb-4">تفاصيل الحساب</h4>

                                    <form method="POST" action="{{ route("profile.password.updateProfile") }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-6">
                                                <!-- Form Group -->
                                                <div class="form-group mb-20">
                                                    <label for="userName" class="mb-2 font-14 bold black">الاسم</label>
                                                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" id="userName" class="theme-input-style"
                                                        placeholder="الاسم">
                                                </div>
                                                <!-- End Form Group -->
                                                <!-- Form Group -->
                                                <div class="form-group mb-20">
                                                    <label for="email" class="mb-2 font-14 bold black">البريد
                                                        الالكتروني</label>
                                                    <input type="email" id="email" name="email" class="theme-input-style"
                                                        placeholder="البريد الالكتروني" value="{{ old('email', auth()->user()->email) }}">
                                                </div>
                                                <!-- End Form Group -->
                                            </div>
                                            <div class="col-xl-4 col-lg-6">
                                                <!-- Form Group -->
                                                <div class="form-group mb-20">
                                                    <label for="name" class="mb-2 font-14 bold black">الاسم
                                                        الاخير</label>
                                                    <input type="text" id="name" name="last_name" class="theme-input-style"
                                                        placeholder="الاسم الاخير" value="{{ old('last_name', auth()->user()->last_name) }}" >
                                                </div>
                                                <!-- End Form Group -->
                                                <div class="form-group mb-20">
                                                    <label for="name" class="mb-2 font-14 bold black"> 
                                                        الهاتف</label>
                                                    <input type="text" id="name" name="phone" class="theme-input-style"
                                                        placeholder=" الجوال" value="{{ old('phone', auth()->user()->phone) }}" >
                                                </div>

                                            </div> 
                                            <div class="col-xl-4">
                                                <div class="upload-avatar d-xl-flex align-items-center flex-column">

                                                    <div>
                                                        <div class="attach-file style--two rounded-0 align-items-end mb-3">
                                                            <img src="{{ auth()->user()->photo ? auth()->user()->photo->getUrl() : asset('assets/img/avatar/user0.png') }}" class="profile-avatar"
                                                                alt="">
                                                            <div class="upload-button mb-20">
                                                                <img src="{{ asset('assets/img/svg/gallery.svg')}}" alt=""
                                                                    class="svg ml-2">
                                                                <span>Upload Photo</span>
                                                                <input class="file-input" type="file" id="fileUpload"
                                                                    accept="image/*" name="photo">
                                                            </div>
                                                        </div>

                                                        <div class="content">
                                                            <h4 class="mb-2">صورة الملف الشخصي</h4>
                                                            <p class="font-12 c4">Allowed JPG, GIF or PNG.<br />
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="button-group mt-30 mt-xl-n5">
                                                    <button type="submit" class="btn"> حفظ التعديلات</button>
                                                    <a href="{{ route('admin.home') }}" 
                                                        class="link-btn bg-transparent mr-3 soft-pink">إلغاء</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="c_pass">
                                    <h4 class="mb-4"> تغيير كلمة المرور</h4>

                                    <form method="POST" action="{{ route("profile.password.update") }}">
                                        @csrf 
                                        <!-- Form Group -->
                                        <div class="form-group mb-20">
                                            <label for="newPassword" class="mb-2 font-14 bold black">كلمة
                                                المرورالجديدة</label>
                                            <input type="password" name="password" id="newPassword" class="theme-input-style"
                                                placeholder="كلمة المرورالجديدة">
                                        </div>
                                        <!-- End Form Group -->
                                        <!-- Form Group -->
                                        <div class="form-group mb-20">
                                            <label for="retypePassword" class="mb-2 font-14 bold black">إعادة كلمة
                                                المرور</label>
                                            <input type="password" name="password_confirmation" id="retypePassword" class="theme-input-style"
                                                placeholder="إعادة كلمة المرور">
                                        </div>
                                        <!-- End Form Group -->

                                        <div class="button-group mt-30">
                                            <button type="submit" class="btn">حفظ التعديلات</button>
                                            <a href="{{ route('admin.home') }}" 
                                                class="link-btn bg-transparent mr-3 soft-pink">إلغاء</a>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="info">
                                    <h4 class="mb-4">البيانات الشخصية</h4>
                                    <div>
                                        <p>الأسم بالكامل : {{ auth()->user()->fullName }}</p>
                                        <p>البريد الألكتروني : {{ auth()->user()->email }}</p>
                                        <p> الهاتف : {{ auth()->user()->phone }}</p>
                                    </div>
                                </div>



                                <div class="tab-pane fade" id="notifications">
                                    <h4 class="mb-5">الإشعارات</h4>
                                    @if(count($alerts = \Auth::user()->userUserAlerts()->withPivot('read')->orderBy('created_at', 'ASC')->get()->reverse()) > 0)
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
                                            <hr>
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>

            </div>
        </div>
    </div>
@endsection
