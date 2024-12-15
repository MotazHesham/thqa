@extends('layouts.admin')
@section('content')
    <div class="main-content">
        <div class="container-fluid">
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
            <!-- Card -->
            <div class="card mb-30">
                <!-- Product Details -->
                <div class="product-details">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="pd-img-wrapp position-relative mb-5 mb-lg-0">
                                @foreach ($building->photos as $media)
                                    @if ($loop->first)
                                        <img id="img_01" src="{{ $media->getUrl() }}"
                                            data-zoom-image="{{ $media->getUrl() }}" alt="" />
                                    @endif
                                @endforeach

                                <div id="gal1">
                                    @foreach ($building->photos as $media)
                                        <a href="#" data-image="{{ $media->getUrl() }}"
                                            data-zoom-image="{{ $media->getUrl() }}">
                                            <img id="img_02" src="{{ $media->getUrl('preview') }}" alt="" />
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <input style="width: 300px;background: white;margin: 10px;" id="pac-input" class="form-control"
                                type="text" placeholder="Search Place" />
                            <div id="map3" style="width: 100%; height: 400px"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-30">
                <div class="product-details">
                    <div class="row">
                        <div class="col-12">
                            <!-- Product Details Content -->
                            <div class="product-details-content position-relative">
                                <!-- Product Title -->
                                <h4 class="product_title">
                                    {{ $building->name ?? '' }}
                                </h4>
                                <!-- End Product Title -->
                                <!-- Product Price -->
                                <p class="price">
                                    <span>{{ App\Models\Building::BUILDING_TYPE_SELECT[$building->building_type] ?? '' }}
                                    </span>
                                </p>
                                <!-- End Product Price -->
                                <!-- End Product Review -->

                                <div class="card-body p-0">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <!-- Form Group -->
                                            <div class="review-list mb-20">
                                                <span class="font-14 bold c4 ml-4">كود</span>
                                                <span class="black">
                                                    {{ $building->code ?? '' }}
                                                </span>
                                            </div>
                                            <div class="review-list mb-20">
                                                <span class="font-14 bold c4 ml-4">المالك</span>
                                                <span class="black">
                                                    {{ $owner->user->fullName ?? '' }}
                                                </span>
                                            </div>
                                            <!-- End Form Group -->
                                            <!-- Form Group -->
                                            <div class="review-list mb-20">
                                                <span class="font-14 bold c4 ml-4">اسم
                                                    العقار</span>
                                                <span class="black">{{ $building->name ?? '' }}</span>
                                            </div>
                                            <!-- End Form Group -->
                                            <!-- Form Group -->
                                            <div class="review-list mb-20">
                                                <span class="font-14 bold c4 ml-4">العنوان</span>
                                                <span class="black">
                                                    {{ $building->address }} - {{ $building->country->name ?? '' }} ,
                                                    {{ $building->city->name ?? '' }}
                                                </span>
                                            </div>
                                            <!-- End Form Group -->
                                            <!-- Form Group -->
                                            <div class="review-list mb-20">
                                                <span class="font-14 bold c4 ml-4">الموظف المسؤول</span>

                                                {{-- {{ $building->employee->fullName ?? '' }} --}}
                                                @foreach ($building->employees as $employee)
                                                    <span class="badge badge-info">{{ $employee->fullName ?? '' }}</span>
                                                @endforeach
                                                </span>
                                            </div>
                                            <!-- End Form Group -->
                                        </div>

                                        <div class="col-lg-6">
                                            <!-- Form Group -->
                                            <div class="review-list mb-20">
                                                <span class="font-14 bold c4 ml-4">النوع</span>
                                                <span
                                                    class="black">{{ $owner->gender ? App\Models\Owner::GENDER_SELECT[$owner->gender] : '' }}</span>
                                            </div>
                                            <!-- End Form Group -->
                                            <!-- Form Group -->
                                            <div class="review-list mb-20">
                                                <span class="font-14 bold c4 ml-4">رقم
                                                    الهوية</span>
                                                <span class="black">
                                                    {{ $owner->identity_num ?? '' }}
                                                </span>
                                            </div>
                                            <!-- End Form Group -->
                                            <!-- Form Group -->
                                            <div class="review-list mb-20">
                                                <span class="font-14 bold c4 ml-4">تاريخ
                                                    الهوية</span>
                                                <span class="black">
                                                    {{ $owner->identity_date ?? '' }}
                                                </span>
                                            </div>

                                            <!-- End Form Group -->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="review-list mb-20">
                                            <span class="font-14 bold c4 ml-5 mr-3">تفاصيل
                                                العقار</span>
                                            <span class="black">
                                                {{ $building->details ?? '' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Product Details Content -->
                    </div>
                </div>
            </div>

            <div class="card mb-30">
                <div class="product-details">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pt-30">
                                    <div class="form-group">
                                        <button class="btn btn-success"  data-toggle="modal" data-target="#SakModal">أضافة جديد</button>
                                    </div>
                                    <div style="display: flex;justify-content: space-between">
                                        <h4 class="font-20">
                                            الصكوك الخاصة بالعقار
                                        </h4>
                                        <form action="{{ route('admin.building-folders.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="building_id" value="{{ $building->id }}">
                                            <input type="hidden" name="type" value="sak">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="folder_name">اسم المجلد</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <br>
                                                    <div class="form-group">
                                                        <button class="btn btn-success">أضافة المجلد</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                    <div class="row mt-5">
                                        <div class="col-md-2">
                                            <div class="card text-center card-folder"
                                                onclick="show_folder_files(null,'{{ $building->id }}','sak')">
                                                <i class="icofont-ui-folder" style="font-size: 50px;color:black"></i>
                                                All
                                            </div>
                                        </div>
                                        @foreach ($building->folders as $folder)
                                            @if ($folder->type == 'sak')
                                                <div class="col-md-2">
                                                    <div class="card text-center card-folder"
                                                        onclick="show_folder_files('{{ $folder->id }}','{{ $building->id }}','sak')">
                                                        <i class="icofont-ui-folder"
                                                            style="font-size: 50px;color:black"></i>
                                                        {{ $folder->name }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-30">
                <div class="product-details">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body pt-30">
                                    <div class="form-group">
                                        <button class="btn btn-success"  data-toggle="modal" data-target="#DocumentModal">أضافة جديد</button>
                                    </div>
                                    <div style="display: flex;justify-content: space-between">
                                        <h4 class="font-20">
                                            المستندات الخاصة بالعقار
                                        </h4>
                                        <form action="{{ route('admin.building-folders.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="building_id" value="{{ $building->id }}">
                                            <input type="hidden" name="type" value="document">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <label for="folder_name">اسم المجلد</label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <br>
                                                    <div class="form-group">
                                                        <button class="btn btn-success">أضافة المجلد</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-md-2">
                                            <div class="card text-center card-folder"
                                                onclick="show_folder_files(null,'{{ $building->id }}','document')">
                                                <i class="icofont-ui-folder" style="font-size: 50px;color:black"></i>
                                                All
                                            </div>
                                        </div>
                                        @foreach ($building->folders as $folder)
                                            @if ($folder->type == 'document')
                                                <div class="col-md-2">
                                                    <div class="card text-center card-folder"
                                                        onclick="show_folder_files('{{ $folder->id }}','{{ $building->id }}','document')">
                                                        <i class="icofont-ui-folder"
                                                            style="font-size: 50px;color:black"></i>
                                                        {{ $folder->name }}
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="card mb-30">
                <div class="product-details">
                    <div class="product-grid pt-5">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="font-20 mb-4">
                                    عقارات اخرى للمالك
                                </h4>
                            </div>
                            @foreach ($owner->ownerBuildings->where('id', '!=', $building->id) as $ownerBuilding)
                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <!-- Product Grid Item -->
                                    <div class="product-grid-item mb-30">
                                        <div class="product-img mb-3">
                                            @forelse($ownerBuilding->photos as $media)
                                                @if ($loop->first)
                                                    <a href="{{ route('admin.buildings.show', $ownerBuilding->id) }}">
                                                        <img src="{{ $media->getUrl('preview') }}" class="w-100" alt="" />
                                                    </a>
                                                @endif 
                                            @empty
                                                <a href="{{ route('admin.buildings.show', $ownerBuilding->id) }}">
                                                    <img src="{{ asset('assets/img/avatar/building.png') }}" class="w-100" alt="" />
                                                </a>
                                            @endforelse
                                        </div>
                                        <div class="product-content">
                                            <h6 class="mb-10">ارض</h6>
                                            <a href="{{ route('admin.buildings.show', $ownerBuilding->id) }}">
                                                <p class="black">
                                                    {{ $ownerBuilding->name }}
                                                </p> 
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Product Grid Item -->
                                </div>
                            @endforeach 
                        </div>
                    </div>
                </div>
                <!-- End Product Grid -->
            </div>
            <!-- End Product Details -->
        </div>
    </div>

    <div class="modal fade" id="SakModal"  aria-labelledby="SakModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    أضافة صك
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>    
                <div class="modal-body">
                    <form method="POST" action="{{ route("admin.building-saks.store") }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="building_id" value="{{ $building->id }}">
                        <input type="hidden" name="dropbox_id" class="dropboxinput">
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">رقم الصك</label>
                                <input type="text" name="sak_num" value="{{ old('sak_num') }}" class="form-control" id="inputName"
                                    placeholder="رقم الصك">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">تاريخ الصك</label>
                                <input type="text" class="form-control date" name="date" value="{{ old('date') }}"
                                    id="inputName" placeholder="تاريخ الصك">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">تاريخ الصك هجري</label>
                                <input type="text" class="form-control hijri-date-input" name="date_hijri" value="{{ old('date_hijri') }}"
                                    id="inputName" placeholder="تاريخ الصك هجري">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">المجلد</label> 
                                @if($folders->count() > 0)
                                    <select name="folder_id" id="" class="form-control" >
                                        <option value="">اختر المجلد</option>
                                        @foreach($folders as $raw)
                                            <option value="{{ $raw->id }}">{{ $raw->name }}</option>
                                        @endforeach
                                    </select> 
                                @else
                                    <input type="text" class="form-control" name="folder_name" id="inputName" placeholder="اسم المجلد">
                                @endif
                            </div>
                            <!-- End Form Group --> 

                            <div class="col-lg-4">
                                <label for="inputName" class="bold mb-2">الملف من دروب بوكس</label>
                                <br>
                                <!-- <input type="file"> -->
                                <div class="attach-file style--three"> 
                                    <div class="upload-button" style="cursor: pointer" onclick="openDropBox('SakModal')">
                                        Choose a file
                                    </div> 
                                </div>
                                <label class="file_upload mr-2"><span class="dropbox">No file added</span></label>
                            </div>
                            <div class="col-lg-4">
                                <label for="inputName" class="bold mb-2">الملف من الجهاز</label>
                                <br>
                                <!-- <input type="file"> -->
                                <div class="attach-file style--three"> 
                                    <div class="upload-button">
                                        Choose a file
                                        <input class="file-input" type="file" name="photo">
                                    </div> 
                                </div>
                                <label class="file_upload mr-2">No file added</label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-success" style="background: #919191;" type="submit">Save</button>   
                            <button class="btn btn-success" type="submit" name="save_more">Save & Add More</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="DocumentModal"  aria-labelledby="DocumentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    أضافة مستند
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>    
                <div class="modal-body">
                    <form method="POST" action="{{ route("admin.building-documents.store") }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="dropbox_id" class="dropboxinput">
                        <input type="hidden" name="building_id" value="{{ $building->id }}">
                        <div class="row">
                            <!-- Form Group -->
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">رقم المستند</label>
                                <input type="text" class="form-control" name="file_num" value="{{ old('file_num') }}"
                                    id="inputName" placeholder="رقم المستند">
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">اسم المستند</label>
                                <input type="text" class="form-control" name="file_name" value="{{ old('file_name') }}"
                                    id="inputName" placeholder="اسم المستند ">
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">نوع المستند</label>
                                <input type="text" class="form-control" name="file_type" value="{{ old('file_type') }}"
                                    id="inputName" placeholder="نوع المستند">
                            </div>
                            <!-- End Form Group -->
                            <!-- Form Group -->
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">تاريخ البداية</label>
                                <input type="text" class="form-control date" name="file_date" value="{{ old('file_date') }}"
                                    id="inputName" placeholder="تاريخ البداية">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">تاريخ البداية هجري</label>
                                <input type="text" class="form-control hijri-date-input" name="file_date_hijri" value="{{ old('file_date_hijri') }}"
                                    id="inputName" placeholder="تاريخ البداية هجري">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">تاريخ الأنتهاء</label>
                                <input type="text" class="form-control date" name="file_date_end" value="{{ old('file_date_end') }}"
                                    id="inputName" placeholder="تاريخ الأنتهاء">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">تاريخ الأنتهاء هجري</label>
                                <input type="text" class="form-control hijri-date-input" name="file_date_hijri_end" value="{{ old('file_date_hijri_end') }}"
                                    id="inputName" placeholder="تاريخ الأنتهاء هجري">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="inputName" class="bold mb-2">المجلد</label> 
                                @if($folders2->count() > 0)
                                    <select name="folder_id" id="" class="form-control" >
                                        <option value="">اختر المجلد</option>
                                        @foreach($folders2 as $raw)
                                            <option value="{{ $raw->id }}">{{ $raw->name }}</option>
                                        @endforeach
                                    </select> 
                                @else
                                    <input type="text" class="form-control" name="folder_name" value="{{ old('folder_name') }}" id="inputName" placeholder="اسم المجلد">
                                @endif
                            </div>
                            <!-- End Form Group --> 

                            <div class="col-lg-4">
                                <label for="inputName" class="bold mb-2">الملف من دروب بوكس</label>
                                <br>
                                <!-- <input type="file"> -->
                                <div class="attach-file style--three"> 
                                    <div class="upload-button" style="cursor: pointer" onclick="openDropBox('DocumentModal')">
                                        Choose a file
                                    </div> 
                                </div>
                                <label class="file_upload mr-2"><span class="dropbox">No file added</span></label>
                            </div>
                            <div class="col-lg-4">
                                <label for="inputName" class="bold mb-2">الملف من الجهاز</label>
                                <br>
                                <!-- <input type="file"> -->
                                <div class="attach-file style--three"> 
                                    <div class="upload-button">
                                        Choose a file
                                        <input class="file-input" type="file" name="photo">
                                    </div> 
                                </div>
                                <label class="file_upload mr-2">No file added</label>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-success" style="background: #919191;" type="submit">Save</button>   
                            <button class="btn btn-success" type="submit" name="save_more">Save & Add More</button>
                        </div>
                    </form>  
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="DropBoxModal"  aria-labelledby="DropBoxModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    أختر الملف
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
                </div>    
                <div class="modal-body">
                    <!-- Spinner to indicate loading -->
                    <div id="loadingSpinner" style="display: none; text-align: center;">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden"> </span>
                        </div>
                    </div>
                    <!-- Content will be loaded here -->
                    <div id="modalContent"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyDjvU8Zqem3c-vJOpHCh4NmzB0xH8FBhQs&libraries=places&v=weekly">
    </script>
    <script src="{{ asset('hijri-date-picker-bootstrap/dist/js/bootstrap-hijri-datetimepicker.js?v2') }}"></script> 
    <script> 
            function openDropBox(modal_id){
                $('#modalContent').html(null);  // Clear content
                $('#loadingSpinner').show();    // Show spinner
                $('#DropBoxModal').modal('show');

                $.post('{{ route('admin.dropbox.index') }}', {
                    _token: '{{ csrf_token() }}',
                    modal_id: modal_id
                }, function(data) {
                    $('#loadingSpinner').hide();          // Hide spinner
                    $('#modalContent').html(data);        // Load content
                });
            }   

            function openDropBoxByPath(path,prev = '',modal_id) {
                $('#modalContent').html(null);   // Clear content
                $('#loadingSpinner').show();     // Show spinner

                $.post('{{ route('admin.dropbox.index') }}', {
                    _token: '{{ csrf_token() }}',
                    path: path,
                    prev: prev,
                    modal_id: modal_id
                }, function(data) {
                    $('#loadingSpinner').hide();         // Hide spinner
                    $('#modalContent').html(data);       // Load content
                });
            } 

            function selectedDropBoxFile(id,name,modal_id){ 
                $('#' + modal_id + ' .file_upload .dropbox').html(name);
                $('#' + modal_id + ' .dropboxinput').val(id);
                $('#DropBoxModal').modal('hide');
            }

            $(function () { 
                initHijrDatePicker();
                
                @if(request()->has('sak_more'))
                    $('#SakModal').modal('show');
                @endif
                
                @if(request()->has('document_more'))
                    $('#DocumentModal').modal('show');
                @endif
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
        <script src="{{ asset('js/map.js') }}"></script>
        <script>
            myMap3({
                coords: {
                    latitude: '{{ $building->map_lat }}',
                    longitude: '{{ $building->map_long }}'
                }
            });
        </script>
        <script src="{{ asset('assets/plugins/elevatezoom/jquery.elevateZoom-3.0.8.min.js') }}"></script>
        <script>
            //initiate the plugin and pass the id of the div containing gallery images
            $("#img_01").elevateZoom({
                gallery: "gal1",
                cursor: "pointer",
                galleryActiveClass: "active",
                imageCrossfade: true,
                loadingIcon: "http://www.elevateweb.co.uk/spinner.gif",
                zoomType: "inner",
                cursor: "crosshair"
            });

            //pass the images to Fancybox
            $("#img_01").bind("click", function(e) {
                var ez = $("#img_01").data("elevateZoom");
                $.fancybox(ez.getGalleryList());
                return false;
            });
        </script>
        <!-- ======= End BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->

        <script>
            function show_folder_files(folder_id, building_id, type) {
                $.post('{{ route('admin.buildings.show_folder_files') }}', {
                    _token: '{{ csrf_token() }}',
                    folder_id: folder_id,
                    building_id: building_id,
                    type: type,
                }, function(data) {
                    $('#AjaxModal .modal-dialog').html(null);
                    $('#AjaxModal').modal('show');
                    $('#AjaxModal .modal-dialog').html(data);
                });
            }
        </script>
@endsection
