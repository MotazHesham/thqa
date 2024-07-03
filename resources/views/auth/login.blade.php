<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Page Title -->
    <title> ثقة </title>

    <!-- Meta Data -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/favicon.png">

    <!-- Web Fonts -->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700,700i&display=swap" rel="stylesheet">

    <!-- ======= BEGIN GLOBAL MANDATORY STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.css') }}">
    <!-- ======= END BEGIN GLOBAL MANDATORY STYLES ======= -->

    <!-- ======= MAIN STYLES ======= -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- ======= END MAIN STYLES ======= -->

</head>

<body>

    <div class=" d-flex align-items-center">
        <div class="container-fluid">
            <!-- Card -->
            <div class="card justify-content-center  vh-100">
                <div class="row align-items-center  justify-content-center">
                    <div class="col-xl-6 col-lg-6 auth-card">
                        <img src="{{ asset('assets/img/logo.png') }}"
                        alt="" />
                        <h4 class="mb-5 font-20">مرحبا بكم في ثقة لإدارة الاملاك </h4>

                        @if(session('message'))
                            <div class="alert alert-info" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif
        
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
    
                            <!-- Form Group -->
                            <div class="form-group mb-20">
                                <label for="text" class="mb-2 font-14 bold black">البريد الألكتروني</label>
                                <input type="email" id="text" name="email" class="theme-input-style"
                                    placeholder="البريد الأكتروني"  required autocomplete="email" autofocus>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="form-group mb-20">
                                <label for="password" class="mb-2 font-14 bold black">كلمة المرور</label>
                                <input type="password" name="password" required id="password" class="theme-input-style" placeholder="********">
                            </div>
                            <!-- End Form Group -->

                            <div class="d-flex justify-content-between mb-20">
                                <div class="d-flex align-items-center">
                                    <!-- Custom Checkbox -->
                                    <label class="custom-checkbox position-relative ml-2">
                                        <input type="checkbox" name="remember" id="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                    <!-- End Custom Checkbox -->

                                    <label for="checkbox" class="font-14">تذكرني</label>
                                </div>

                                {{-- <a href="forget-pass.html" class="font-12 text_color">نسيت كلمة المرور</a> --}}
                            </div>



                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn long ml-20">تسجيل الدخول</button>
                                {{-- <span class="font-12 d-block"> ليس لديك حساب <a href="register.html" class="bold">
                                        تسجيل مستخدم جديد </a> </span> --}}
                            </div>
                        </form>
                    </div>

                    <div class="col-xl-6 col-lg-6" style="padding: 0">
                        <div class="login_bg">

                        </div>
                    </div>
                </div>
            </div>
            <!-- End Card -->
        </div>
    </div>



    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <!-- ======= BEGIN GLOBAL MANDATORY SCRIPTS ======= -->
</body>

</html>
