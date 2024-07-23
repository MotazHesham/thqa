@extends('layouts.admin')
@section('content')
    <div class="main-content">
        <div class="container-fluid">
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
                                    <h4 class="font-20">
                                        الصكوك الخاصة بالعقار
                                    </h4>
                                </div>
                                <div class="table-responsive">
                                    <!-- Invoice List Table -->
                                    <table class="text-nowrap table-contextual dh-table">
                                        <thead>
                                            <tr>
                                                <th>اسم الصك</th>
                                                <th>عرض</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($building->buildingBuildingSaks as $sak)
                                                <tr>
                                                    <td>{{ $sak->sak_num }}</td>
                                                    <td>
                                                        <a href="{{ $sak->photo ? $sak->photo->getUrl() : '' }}"
                                                            class="details-btn">عرض
                                                            <i class="icofont-arrow-left"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- End Invoice List Table -->
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
                                    <h4 class="font-20">
                                        المستندات الخاصة بالعقار
                                    </h4>
                                </div>
                                <div class="table-responsive">
                                    <!-- Invoice List Table -->
                                    <table class="text-nowrap table-contextual dh-table">
                                        <thead>
                                            <tr>
                                                <th>رقم المستند</th>
                                                <th>اسم المستند</th>
                                                <th>نوع المستند</th>
                                                <th>تاريخ المستند</th>
                                                <th>عرض</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($building->buildingBuildingDocuments as $document)
                                                <tr>
                                                    <td>{{ $document->file_num }}</td>
                                                    <td>{{ $document->file_name }}</td>
                                                    <td>{{ $document->file_type }}</td>
                                                    <td>{{ $document->file_date }}</td>
                                                    <td>
                                                        <a href="{{ $document->photo ? $document->photo->getUrl() : '' }}"
                                                            class="details-btn">عرض
                                                            <i class="icofont-arrow-left"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- End Invoice List Table -->
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
@endsection
@section('scripts')
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyDjvU8Zqem3c-vJOpHCh4NmzB0xH8FBhQs&libraries=places&v=weekly">
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
@endsection)
