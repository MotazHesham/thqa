@extends('layouts.admin')
@section('content')
    <div class="main-content">
        <div class="container-fluid">
            <!-- Card -->
            <div class="card mb-30">
                <form action="">
                    <div class="form-element py-30">
                        <h3 class="font-20 mb-3 text-transform-none">
                            تقارير العقارات
                        </h3>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block">نوع التاريخ</label>
                                    <div class="custom-select style--two">
                                        <select class="theme-input-style select2" name="date_type" id="exampleSelect1">
                                            <option value="" selected>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach (App\Models\Building::DATE_TYPE as $key => $label)
                                                <option value="{{ $key }}" 
                                                {{ $date_type == $key ? 'selected' : '' }}>
                                                    {{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <!-- Form Group -->
                                <div class="form-group mb-4">
                                    <label class="mb-2 font-14 bold">من</label>

                                    <!-- Date Picker -->
                                    <div class="dashboard-date style--four">
                                        <span class="input-group-addon">
                                            <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg" />
                                        </span>

                                        <input type="text" class="date" name="from_date" value="{{ request('from_date') }}" id="default-date" placeholder="اختر التاريخ" />
                                    </div>
                                    <!-- End Date Picker -->
                                </div>
                                <!-- End Form Group -->
                            </div>

                            <div class="col-md-3">
                                <!-- Form Group -->
                                <div class="form-group mb-4">
                                    <label class="mb-2 font-14 bold">إلى</label>

                                    <!-- Date Picker -->
                                    <div class="dashboard-date style--four">
                                        <span class="input-group-addon">
                                            <img src="{{ asset('assets/img/svg/calender.svg') }}" alt="" class="svg" />
                                        </span>

                                        <input type="text" class="date" name="to_date" value="{{ request('to_date') }}" id="formate-date" placeholder="اختر التاريخ" />
                                    </div>
                                    <!-- End Date Picker -->
                                </div>
                                <!-- End Form Group -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block"> البلد</label>
                                    <div class="custom-select style--two">
                                        <select class="theme-input-style select2" id="country_id" name="country_id" onchange="get_cities()">
                                            @foreach ($countries as $id => $entry)
                                                <option value="{{ $id }}"
                                                {{ $country_id == $id ? 'selected' : '' }}>
                                                    {{ $entry }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block"> المحافطة</label>
                                    <div class="custom-select style--two">
                                        <select class="theme-input-style select2" id="city_id" name="city_id" onchange="get_cities()">
                                            @foreach ($cities as $id => $entry)
                                                <option value="{{ $id }}"
                                                {{ $city_id == $id ? 'selected' : '' }}>
                                                    {{ $entry }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> العنوان </label>
                                    <input type="number" name="address" value="{{ $address }}" 
                                        class="theme-input-style" placeholder="العنوان">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> اسم العقار </label>
                                    <input type="number" name="name" value="{{ $name }}" 
                                        class="theme-input-style" placeholder="اسم العقار">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block">نوع العقار</label>
                                    <div class="custom-select style--two">
                                        <select class="theme-input-style select2" name="building_type" id="exampleSelect1">
                                            <option value="" selected>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach (App\Models\Building::BUILDING_TYPE_SELECT as $key => $label)
                                                <option value="{{ $key }}" {{ $building_type == $key ? 'selected' : '' }}>
                                                    {{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block"> حالة العقار</label>
                                    <div class="custom-select style--two">
                                        <select class="theme-input-style select2" name="building_status" id="exampleSelect1">
                                            <option value="" selected>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach (App\Models\Building::BUILDING_STATUS_SELECT as $key => $label)
                                                <option value="{{ $key }}" {{ $building_status == $key ? 'selected' : '' }}>
                                                    {{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> رقم الهوية </label>
                                    <input type="number" name="identity_num" value="{{ $identity_num }}" 
                                        class="theme-input-style" placeholder="الهوية">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="font-14 bold mb-2"> رقم الهاتف </label>
                                    <input type="number" name="phone" value="{{ $phone }}" 
                                        class="theme-input-style" placeholder="رقم الهاتف">
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block">  المالك</label>
                                    <div class="custom-select style--two" style="    height: 44px; padding: 7px 0;">
                                        <select class="theme-input-style select2" id="exampleSelect1" name="owner_id"
                                            >
                                            <option value="" selected>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach ($owners as $owner)
                                                <option value="{{ $owner->id }}" {{ $owner_id == $owner->id ? 'selected' : '' }}>
                                                    {{ $owner->user->fullName ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <!-- Form Group -->
                                <div class="form-group">
                                    <label for="exampleSelect1" class="mb-2 black bold d-block">  الموظف المسؤول</label>
                                    <div class="custom-select style--two" style="    height: 44px; padding: 7px 0;">
                                        <select class="theme-input-style select2" id="exampleSelect1" name="employee_id"
                                            >
                                            <option value="" selected>{{ trans('global.pleaseSelect') }}</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}" {{ $employee_id == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->fullName ?? '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button class="btn sw-btn-next" type="submit" name="search">
                            عرض
                        </button>
                        <a href="{{ route('admin.report-buildings.index') }}" 
                            class="link-btn bg-transparent mr-3 soft-pink">إلغاء</a>
                    </div>
                </form>
            </div>
            <!-- End Card -->

            @if($search)
                <p>أجمالي نتائج البحث {{ $buildings->total() }}</p>
                <div class="table-responsive">
                    <!-- Invoice List Table --> 
                    <table class="contact-list-table text-nowrap bg-white">
                        <thead>
                            <tr> 
                                <th>#</th>
                                <th>اسم العقار </th>
                                <th>النوع</th>
                                <th>الموقع</th>
                                <th>المالك</th> 
                                @if(auth()->user()->is_admin)
                                    <th>الموظف</th> 
                                @endif
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buildings as $key => $building)
                                <tr data-entry-id="{{ $building->id }}"> 
                                    <td>{{ $building->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="img ml-20">
                                                @forelse($building->photos as $key => $media)
                                                    <img src="{{ $media->getUrl('thumb') }}" class="img-40" alt=""> 
                                                @empty 
                                                    <img src="{{ asset('assets/img/avatar/building.png') }}" class="img-40" alt=""> 
                                                @endforelse
                                            </div>
                                            <div class="name bold">
                                                <a href="{{ route('admin.buildings.show',$building->id) }}"> {{ $building->name }} </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ App\Models\Building::BUILDING_TYPE_SELECT[$building->building_type] ?? '' }}</td>
                                    <td>{{ $building->country->name ?? ''}} - {{ $building->city->name ?? '' }}</td>
                                    <td> <a href="#">{{ $building->owner->user->fullName ?? '' }}</a></td> 
                                    @if(auth()->user()->is_admin)
                                        <td> <a href="#">{{ $building->employee->fullName ?? '' }}</a></td> 
                                    @endif 
                                    <td></td>
                                </tr> 
                            @endforeach
                        </tbody>
                    </table>
                    <!-- End Invoice List Table -->
                </div>
                {{ $buildings->links() }}
            @endif 
        </div>
    </div>
@endsection
