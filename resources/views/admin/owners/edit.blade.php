@extends('layouts.admin') 
@section('content')
    <!-- Main Content -->
    <div class="main-content d-flex flex-column flex-md-row" style="overflow: visible">
        <div class="container-fluid">
            <div class="card mb-30">
                @if(session('message'))
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                @endif
                @if($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif 
                <!-- Form -->
                <form method="POST" action="{{ route("admin.owners.update", [$owner->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    
                        <input type="hidden" name="user_id" value="{{ $owner->user_id }}">

                        <!-- User Details -->
                        <div class="card-body p-4">
                            <h4 class="font-20 mb-20">بيانات العميل </h4>

                            <div class="row">
                                <div class="col-lg-6">
                                    <!-- Form Group -->
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2">الاسم الاول</label>
                                        <input type="text" class="theme-input-style" name="name" placeholder="الاسم الاول"
                                            required value="{{ old('name', $user->name) }}">
                                    </div>
                                </div>
                                <!-- End Form Group -->

                                <div class="col-lg-6">
                                    <!-- Form Group -->
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2">الاسم الاخير</label>
                                        <input type="text" class="theme-input-style" name="last_name" placeholder="الاسم الاخير"
                                            required value="{{ old('last_name', $user->last_name) }}">
                                    </div>
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2">البريد الالكتروني</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="theme-input-style"
                                            placeholder="البريد الالكتروني للمالك">
                                    </div>
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleSelect1" class="mb-2 black bold d-block">النوع</label>
                                        <div class="custom-select style--two">
                                            <select class="theme-input-style" id="exampleSelect1" name="gender">
                                                @foreach(App\Models\Owner::GENDER_SELECT as $key => $label)
                                                    <option value="{{ $key }}" {{ old('gender', $owner->gender) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2"> الجوال</label>
                                        <input type="number" class="theme-input-style"  name="phone" value="{{ old('phone', $user->phone) }}" placeholder="الجوال">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2"> جوال أخر</label>
                                        <input type="number" class="theme-input-style"  name="phone2" value="{{ old('phone2', $user->phone2) }}" placeholder="جوال أخر">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2"> الهاتف</label>
                                        <input type="number" class="theme-input-style"  name="mobile" value="{{ old('mobile', $user->mobile) }}" placeholder="الهاتف">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2"> هاتف أخر</label>
                                        <input type="number" class="theme-input-style"  name="mobile2" value="{{ old('mobile2', $user->mobile2) }}" placeholder="هاتف أخر">
                                    </div>
                                </div>
                                <!-- End Form Group --> 
                                <!-- Form Group -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2"> رقم الهوية</label>
                                        <input type="number" class="theme-input-style" name="identity_num" value="{{ old('identity_num', $owner->identity_num) }}" placeholder="رقم الهوية">
                                    </div>
                                </div>
                                <!-- End Form Group -->

                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label class="mb-2 black bold">تاريخها</label>

                                        <!-- Date Picker -->
                                        <div class="dashboard-date style--two">
                                            <span class="input-group-addon">
                                                <img src="{{ asset('assets/img/svg/calender.svg') }}" alt=""
                                                    class="svg">
                                            </span>

                                            <input type="text" class="date" name="identity_date" value="{{ old('identity_date', $owner->identity_date) }}" placeholder="28 October 2019">
                                        </div>
                                    </div>
                                    <!-- End Date Picker -->
                                </div>



                                <!-- Form Group -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2"> العنوان الوطني</label>
                                        <input type="text" class="theme-input-style"
                                            placeholder=" العنوان الوطني" name="address" value="{{ old('address', $owner->address) }}">
                                    </div>
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2"> السجل التجاري </label>
                                        <input type="text" class="theme-input-style"
                                            placeholder=" السجل التجاري " name="commerical_num" value="{{ old('commerical_num', $owner->commerical_num) }}">
                                    </div>
                                </div>
                                <!-- End Form Group -->
                                <!-- Form Group -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2"> الهوية العقارية </label>
                                        <input type="text" class="theme-input-style"
                                            placeholder="الهوية العقارية " name="real_estate_identity" value="{{ old('real_estate_identity', $owner->real_estate_identity) }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="font-14 bold mb-2"> الصورة الشخصية </label>
                                        <br>
                                        <div class="attach-file style--three">
                                            <div class="upload-button">
                                                Choose a file
                                                <input class="file-input" type="file" name="photo">
                                            </div>
                                        </div>
                                        <label class="file_upload mr-2">No file added</label>
                                    </div>
                                </div>
                                <!-- End Form Group -->
                            </div> 
                        <!-- End User Details -->
                        <button class="btn btn-success" type="submit">Save</button>
                    </div>  
                </form>
                <!-- End Form -->
            </div>
        </div>
    </div>
    <!-- End Main Content -->
@endsection
@section('scripts')
    <!-- ======= BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
    <script src="{{ asset('assets/plugins/jquery-smartwizard/jquery.smartWizard.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-smartwizard/custom-smartWizard.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery.steps/custom-jquery-step.js') }}"></script>
    <!-- ======= End BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
    <!-- ======= BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
    <script src="{{ asset('assets/plugins/jquery-repeater/repeater.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery-repeater/custom-repeater.js') }}"></script>
    <!-- ======= End BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
@endsection
