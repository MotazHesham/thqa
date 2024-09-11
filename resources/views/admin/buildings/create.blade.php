@extends('layouts.admin')
@section('content')
    <!-- Main Content -->
    <div class="main-content d-flex flex-column flex-md-row">
        <div class="container-fluid">
            <!-- Main Content -->
            @if (session('message'))
                <div class="row mb-2">
                    <div class="col-lg-12">
                        <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                    </div>
                </div>
            @endif
            @if ($errors->count() > 0)
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- End Main Content -->
            <!-- Form -->
            <form action="{{ route('admin.buildings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card mb-30">
                    @csrf
                    <div class="card-body">
                        <h4 class="font-20 mb-20"> بيانات العقار </h4>

                        <div class="row">
                            <div class="col-lg-6">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block"> اسم المالك</label>
                                    <div class="custom-select style--two" style="    height: 44px; padding: 7px 0;">
                                        <select class="theme-input-style select2" id="exampleSelect1" name="owner_id"
                                            required>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}"
                                                    {{ (old('owner_id') ? old('owner_id') : $building->owner->id ?? '') == $owner->id ? 'selected' : '' }}>
                                                    (TH - {{ $owner->id }}) {{ $owner->user->fullName ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <div class="col-lg-6 mb-4">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> اسم العقار</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="theme-input-style" placeholder="  ">
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-2 mt-4"> 
                                <div class="form-group">
                                    <label class="font-14 bold mb-2">خط العرض</label>
                                    <input type="text" name="map_lat" id="map_lat" value="24.6" required
                                        class="theme-input-style" placeholder="  " onkeyup="changeLatLong()">
                                </div>  
                                <div class="form-group">
                                    <label class="font-14 bold mb-2">خط الطول</label>
                                    <input type="text" name="map_long" id="map_long" value="46.6" required
                                        class="theme-input-style" placeholder="  " onkeyup="changeLatLong()">
                                </div> 
                            </div>
                            <div class="col-lg-10 mt-4">
                                <input style="width: 300px;background: white;margin: 10px;" id="pac-input"
                                    class="form-control" type="text" placeholder="Search Place" />
                                <div id="map3" class="mb-4" style="width: 100%; height: 400px"></div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block"> الدولة</label>
                                    <div class="custom-select style--two">
                                        <select class="theme-input-style select2" id="country_id" name="country_id" required
                                            onchange="get_cities()">
                                            @foreach ($countries as $id => $entry)
                                                <option value="{{ $id }}" {{ 188 == $id ? 'selected' : '' }}>
                                                    {{ $entry }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block"> المدينة </label>
                                    <div class="custom-select style--two" id="cities">
                                        <select class="theme-input-style select2" id="exampleSelect1" required>
                                            <option value="">اختر المدينة </option>
                                            {{-- ajax call --}}
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> العنوان </label>
                                    <input type="text" name="address" value="{{ old('address') }}"
                                        class="theme-input-style" id="address" placeholder="العنوان">
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block">نوع العقار</label>
                                    <div class="custom-select style--two">
                                        <select class="theme-input-style select2" name="building_type" id="exampleSelect1">
                                            @foreach (App\Models\Building::BUILDING_TYPE_SELECT as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ old('building_type', 'apartment') === (string) $key ? 'selected' : '' }}>
                                                    {{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block"> حالة العقار</label>
                                    <div class="custom-select style--two">
                                        <select class="theme-input-style select2" name="building_status"
                                            id="exampleSelect1">
                                            @foreach (App\Models\Building::BUILDING_STATUS_SELECT as $key => $label)
                                                <option value="{{ $key }}"
                                                    {{ old('building_status', 'empty') === (string) $key ? 'selected' : '' }}>
                                                    {{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <div class="col-lg-4">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block"> الموظف المسؤول</label>
                                    <div class="custom-select style--two" style="    height: 44px; padding: 7px 0;">
                                        {{-- <select class="theme-input-style select2" id="exampleSelect1" name="employee_id"
                                                required>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ (old('employee_id') ? old('employee_id') : $building->employee->id ?? '') == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->fullName }}</option>
                                                @endforeach
                                            </select> --}}
                                        <select class="theme-input-style select2" id="exampleSelect1" name="employees[]" id="employees" multiple>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}">{{ $employee->fullName }}</option>
                                            @endforeach
                                            <option value="all">اختر الكل</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- End Form -->
                </div>


                <div class="card mb-30">
                    <div class="card-body">
                        <h4 class="font-20 mb-20"> بيانات العقار </h4>

                        <div class="row">
                            <!-- Form Group -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> تاريخ التمليك</label>
                                    <input type="text" class="theme-input-style date" name="owned_date"
                                        value="{{ old('owned_date') }}" placeholder="تاريخ التمليك">
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> تاريخ التسجيل</label>
                                    <input type="text" class="theme-input-style date" name="registration_date"
                                        value="{{ old('registration_date') }}" placeholder="تاريخ التسجيل">
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> قرار مساحي </label>
                                    <input type="text" class="theme-input-style" name="survey_descision"
                                        value="{{ old('survey_descision') }}" placeholder="قرار مساحي ">
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> السجل التجاري </label>
                                    <input type="text" class="theme-input-style" name="commerical_num"
                                        value="{{ old('commerical_num') }}" placeholder=" السجل التجاري ">
                                </div>
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> الهوية العقارية </label>
                                    <input type="text" class="theme-input-style" name="real_estate_identity"
                                        value="{{ old('real_estate_identity') }}" placeholder="الهوية العقارية ">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> تفاصيل العقار </label>
                                    <textarea type="text" class="theme-input-style" name="details" placeholder="تفاصيل العقار ">{{ old('details') }}</textarea>
                                </div>
                            </div>
                            <!-- End Form Group -->
                        </div>
                    </div>
                </div>


                <div class="card mb-30">

                    <div class="col-12">
                        <!-- Form Element -->
                        <div class="form-element py-30 mb-30">
                            <!-- Repeater Heading -->
                            <div class="repeater-heading">
                                <h4 class="font-20 mb-4"> اضافة صور العقار</h4>
                            </div>
                            <div class="needsclick dropzone {{ $errors->has('photos') ? 'is-invalid' : '' }}"
                                id="photos-dropzone">
                            </div>
                        </div>
                        <!-- End Form Element -->
                    </div>

                </div>


                <div class="card mb-30">

                    <div class="col-12">
                        <!-- Form Element -->
                        <div class="form-element py-30 mb-30">
                            <!-- Repeater Heading -->
                            <div class="repeater-heading">
                                <h4 class="font-20 mb-4"> اضافة صكوك الملكية</h4>
                            </div>

                            <div id="sak-container">
                                <!-- Repeater Content -->
                                <div class="item-content align-items-center row">

                                    <!-- Form Group -->
                                    <div class="form-group col-lg-2">
                                        <label for="inputName" class="bold mb-2">رقم الصك</label>
                                        <input type="text" name="saks[1][num]" class="form-control" id="inputName"
                                            placeholder="رقم الصك">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="inputName" class="bold mb-2">تاريخ الصك</label>
                                        <input type="text" class="form-control date" name="saks[1][date]"
                                            id="inputName" placeholder="تاريخ الصك">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="inputName" class="bold mb-2">تاريخ الصك هجري</label>
                                        <input type="text" class="form-control hijri-date-input" name="saks[1][date_hijri]"
                                            id="inputName" placeholder="تاريخ الصك هجري">
                                    </div>
                                    <!-- End Form Group -->



                                    <div class="col-lg-4">
                                        <!-- <input type="file"> -->
                                        <div class="attach-file style--three">
                                            <div class="upload-button">
                                                Choose a file
                                                <input class="file-input" type="file" name="saks[1][photo]">
                                            </div>
                                        </div>
                                        <label class="file_upload mr-2">No file added</label>
                                    </div>


                                    <!-- Repeater Remove Btn -->
                                    <div class="repeater-remove-btn col-lg-1">
                                        <button class="remove-btn" type="button" onclick="delete_row(this)">
                                            <img src="{{ asset('assets/img/svg/remove.svg') }}" alt=""
                                                class="svg">
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <hr />
                            <!-- Repeater End -->
                            <button type="button" onclick="add_more_sak()" class="repeater-add-btn btn-circle">
                                <img src="{{ asset('assets/img/svg/plus_white.svg') }}" alt="" class="svg">
                            </button>
                        </div>
                        <!-- End Form Element -->
                    </div>

                </div>


                <div class="card mb-30">

                    <div class="col-12">
                        <!-- Form Element -->
                        <div class="form-element py-30 mb-30">
                            <!-- Repeater Heading -->
                            <div class="repeater-heading">
                                <h4 class="font-20 mb-4"> اضافة مستندات</h4>
                            </div>

                            <!-- Repeater Html Start -->
                            <div id="file-container">
                                <div class="item-content align-items-center row">

                                    <!-- Form Group -->
                                    <div class="form-group col-lg-2">
                                        <label for="inputName" class="bold mb-2">رقم المستند</label>
                                        <input type="text" class="form-control" name="documents[1][num]"
                                            id="inputName" placeholder="رقم المستند">
                                    </div>
                                    <!-- End Form Group -->
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-2">
                                        <label for="inputName" class="bold mb-2">اسم المستند</label>
                                        <input type="text" class="form-control" name="documents[1][name]"
                                            id="inputName" placeholder="اسم المستند ">
                                    </div>
                                    <!-- End Form Group -->
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-2">
                                        <label for="inputName" class="bold mb-2">نوع المستند</label>
                                        <input type="text" class="form-control" name="documents[1][type]"
                                            id="inputName" placeholder="نوع المستند">
                                    </div>
                                    <!-- End Form Group -->
                                    <!-- Form Group -->
                                    <div class="form-group col-lg-2">
                                        <label for="inputName" class="bold mb-2">تاريخ البداية</label>
                                        <input type="text" class="form-control date" name="documents[1][date]"
                                            id="inputName" placeholder="تاريخ البداية">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="inputName" class="bold mb-2">تاريخ البداية هجري</label>
                                        <input type="text" class="form-control hijri-date-input" name="documents[1][date_hijri]"
                                            id="inputName" placeholder="تاريخ البداية هجري">
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="inputName" class="bold mb-2">تاريخ الأنتهاء</label>
                                        <input type="text" class="form-control date" name="documents[1][date_end]"
                                            id="inputName" placeholder="تاريخ الأنتهاء">
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="inputName" class="bold mb-2">تاريخ الأنتهاء هجري</label>
                                        <input type="text" class="form-control hijri-date-input" name="documents[1][date_hijri_end]"
                                            id="inputName" placeholder="تاريخ الأنتهاء هجري">
                                    </div>
                                    <!-- End Form Group -->




                                    <div class="col-lg-3">
                                        <!-- <input type="file"> -->
                                        <div class="attach-file style--three">
                                            <div class="upload-button">
                                                Choose a file
                                                <input class="file-input" type="file" name="documents[1][photo]">
                                            </div>
                                        </div>
                                        <label class="file_upload mr-2">No file added</label>
                                    </div>


                                    <!-- Repeater Remove Btn -->
                                    <div class="repeater-remove-btn col-lg-1">
                                        <button data-repeater-delete class="remove-btn">
                                            <img src="{{ asset('assets/img/svg/remove.svg') }}" alt=""
                                                class="svg">
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <hr />
                            <!-- Repeater End -->
                            <button type="button" class="repeater-add-btn btn-circle" onclick="add_more_file()">
                                <img src="{{ asset('assets/img/svg/plus_white.svg') }}" alt="" class="svg">
                            </button>
                        </div>
                        <!-- End Form Element -->
                    </div>

                </div>
                <button class="btn btn-success" type="submit">Save</button>
            </form>
        </div>
    </div>
    <!-- End Main Content -->
@endsection

@section('scripts')
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyDjvU8Zqem3c-vJOpHCh4NmzB0xH8FBhQs&libraries=places&v=weekly">
    </script>
    <script src="{{ asset('js/map.js') }}"></script>
    <script>
        locate();
    </script>
    <script src="{{ asset('hijri-date-picker-bootstrap/dist/js/bootstrap-hijri-datetimepicker.js?v2') }}"></script> 
    <script>
        
        $(function () { 
            initHijrDatePicker();

        }); 

        function initHijrDatePicker() { 

            $(".hijri-date-input").hijriDatePicker({
                locale: "ar-sa",
                format: "DD-MM-YYYY",
                hijriFormat: "iDD/iMM/iYYYY",
                dayViewHeaderFormat: "MMMM YYYY",
                hijriDayViewHeaderFormat: "iMMMM iYYYY",
                showSwitcher: false,
                allowInputToggle: true,
                showTodayButton: false,
                useCurrent: true,
                isRTL: false,
                viewMode: "months",
                keepOpen: false,
                hijri: true,
                debug: false,
                showClear: true,
                showTodayButton: true,
                showClose: true,
            });

            $('.date').datetimepicker({
                format: 'DD/MM/YYYY',
                locale: 'en',
                icons: {
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right'
                }, 
            })
            $('.prev span').removeClass();
            $('.prev span').addClass("fa fa-chevron-left");

            $('.next span').removeClass();
            $('.next span').addClass("fa fa-chevron-right");
        } 
    </script>
    <script>
        var sak_count = 2;

        function add_more_sak() {
            $('#sak-container').append(
                `<div class="item-content align-items-center row"> 
                    <div class="form-group col-lg-2">
                        <label for="inputName" class="bold mb-2">رقم الصك</label>
                        <input type="text" name="saks[${sak_count}][num]" class="form-control"
                            id="inputName" placeholder="رقم الصك">
                    </div>  
                    <div class="form-group col-lg-2">
                        <label for="inputName" class="bold mb-2">تاريخ الصك</label>
                        <input type="text" class="form-control date" name="saks[${sak_count}][date]" id="inputName"
                            placeholder="تاريخ الصك">
                    </div>  
                    <div class="form-group col-lg-2">
                        <label for="inputName" class="bold mb-2">تاريخ الصك هجري</label>
                        <input type="text" class="form-control hijri-date-input" name="saks[${sak_count}][date_hijri]" id="inputName"
                            placeholder="تاريخ الصك هجري">
                    </div>  
                    <div class="col-lg-4"> 
                        <div class="attach-file style--three">
                            <div class="upload-button">
                                Choose a file
                                <input class="file-input" type="file" name="saks[${sak_count}][photo]">
                            </div>
                        </div>
                        <label class="file_upload mr-2">No file added</label>
                    </div> 
                    <div class="repeater-remove-btn col-lg-1">
                        <button  class="remove-btn" type="button" onclick="delete_row(this)">
                            <img src="${ "{{ asset('assets/img/svg/remove.svg') }}" }" alt=""
                                class="svg">
                        </button>
                    </div> 
                </div>`
            );
            sak_count++;

            initHijrDatePicker(); 
        }

        var file_count = 2;

        function add_more_file() {
            $('#file-container').append(
                `<div class="item-content align-items-center row"> 
                    <div class="form-group col-lg-2">
                        <label for="inputName" class="bold mb-2">رقم المستند</label>
                        <input type="text" class="form-control" name="documents[${file_count}][num]" id="inputName"
                            placeholder="رقم المستند">
                    </div> 
                    <div class="form-group col-lg-2">
                        <label for="inputName" class="bold mb-2">اسم المستند</label>
                        <input type="text" class="form-control" name="documents[${file_count}][name]" id="inputName"
                            placeholder="اسم المستند ">
                    </div> 
                    <div class="form-group col-lg-2">
                        <label for="inputName" class="bold mb-2">نوع المستند</label>
                        <input type="text" class="form-control" name="documents[${file_count}][type]" id="inputName"
                            placeholder="نوع المستند">
                    </div> 
                    <div class="form-group col-lg-2">
                        <label for="inputName" class="bold mb-2">تاريخ البداية</label>
                        <input type="text" class="form-control date" name="documents[${file_count}][date]" id="inputName"
                            placeholder="تاريخ البداية">
                    </div>  
                    <div class="form-group col-lg-2">
                        <label for="inputName" class="bold mb-2">تاريخ البداية هجري</label>
                        <input type="text" class="form-control hijri-date-input" name="documents[${file_count}][date_hijri]" id="inputName"
                            placeholder="تاريخ البداية هجري">
                    </div>  
                    <div class="form-group col-lg-2">
                        <label for="inputName" class="bold mb-2">تاريخ الأنتهاء</label>
                        <input type="text" class="form-control date" name="documents[${file_count}][date_end]" id="inputName"
                            placeholder="تاريخ الأنتهاء">
                    </div>  
                    <div class="form-group col-lg-4">
                        <label for="inputName" class="bold mb-2">تاريخ الأنتهاء هجري</label>
                        <input type="text" class="form-control hijri-date-input" name="documents[${file_count}][date_hijri_end]" id="inputName"
                            placeholder="تاريخ الأنتهاء هجري">
                    </div>  
                    <div class="col-lg-3"> 
                        <div class="attach-file style--three">
                            <div class="upload-button">
                                Choose a file
                                <input class="file-input" type="file" name="documents[${file_count}][photo]">
                            </div>
                        </div>
                        <label class="file_upload mr-2">No file added</label>
                    </div> 
                    <div class="repeater-remove-btn col-lg-1">
                        <button data-repeater-delete class="remove-btn">
                            <img src="${ "{{ asset('assets/img/svg/remove.svg') }}" }" alt=""
                                class="svg">
                        </button>
                    </div> 
                </div>`
            );
            file_count++; 
            
            initHijrDatePicker();
        }

        function delete_row(em) {
            $(em).closest('.row').remove();
        }
    </script>
    <script>
        window.onload = get_cities();

        function get_cities() {
            var country_id = $('#country_id').val();
            $.ajax({
                method: 'POST',
                url: '{{ route('admin.countries.get_cities') }}',
                data: {
                    id: country_id,
                    _token: '{{ csrf_token() }}',
                }
            }).done(function(data) {
                $('#cities').html(data);
                $('#city_id').select2();
            })
        }
    </script>
    <script>
        var uploadedPhotosMap = {}
        Dropzone.options.photosDropzone = {
            url: '{{ route('admin.buildings.storeMedia') }}',
            maxFilesize: 4, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 4,
                width: 4096,
                height: 4096
            },
            success: function(file, response) {
                $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
                uploadedPhotosMap[file.name] = response.name
            },
            removedfile: function(file) {
                console.log(file)
                file.previewElement.remove()
                var name = ''
                if (typeof file.file_name !== 'undefined') {
                    name = file.file_name
                } else {
                    name = uploadedPhotosMap[file.name]
                }
                $('form').find('input[name="photos[]"][value="' + name + '"]').remove()
            },
            init: function() {
                @if (isset($building) && $building->photos)
                    var files = {!! json_encode($building->photos) !!}
                    for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
                    }
                @endif
            },
            error: function(file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
@endsection
