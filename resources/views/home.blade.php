@extends('layouts.admin')
@section('content')

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-4 col-sm-6">
                    <!-- Card -->
                    <a href="{{ route('admin.buildings.index') }}" class="card mb-30 shadow">
                        <div class="state">
                            <div class="d-flex align-items-center flex-wrap">
                                <div class="state-icon d-flex justify-content-center">
                                    <img src="{{ asset('assets/img/home_icon_1.png') }}" alt="" />
                                </div>
                                <div class="state-content">
                                    <p class="font-14 mb-2">
                                        {{ $settings1['chart_title'] }}
                                    </p>
                                    <h2>{{ number_format($settings1['total_number']) }}</h2>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                </div>

                <div class="col-xl-4 col-sm-6">
                    <!-- Card -->
                    <a href="{{ route('admin.owners.index') }}" class="card shadow mb-30">
                        <div class="state">
                            <div class="d-flex align-items-center flex-wrap">
                                <div class="state-icon d-flex justify-content-center">
                                    <img src="{{ asset('assets/img/home_icon_2.png') }}" alt="" />
                                </div>
                                <div class="state-content">
                                    <p class="font-14 mb-2">
                                        {{ $settings2['chart_title'] }}
                                    </p>
                                    <h2>{{ number_format($settings2['total_number']) }}</h2>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                </div>

                <div class="col-xl-4 col-sm-6">
                    <!-- Card -->
                    <a href="{{ route('admin.buildings.index') }}" class="card mb-30 shadow">
                        <div class="state">
                            <div class="d-flex align-items-center flex-wrap">
                                <div class="state-icon d-flex justify-content-center">
                                    <img src="{{ asset('assets/img/home_icon_3.png') }}" alt="" />
                                </div>
                                <div class="state-content">
                                    <p class="font-14 mb-2">
                                        {{ $settings3['chart_title'] }}
                                    </p>
                                    <h2>{{ number_format($settings3['total_number']) }} </h2>
                                </div>
                            </div>
                        </div>
                    </a>
                    <!-- End Card -->
                </div>

                <div class="col-md-12"> 
                    <div class="card mb-30 shadow" style="overflow: scroll;height: 540px;">
                        <div class="card-body">
                            <div class="card mb-30 shadow">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="title-content mb-5">
                                            <h4 class="mb-2">
                                                مستندات قاربت علي الانتهاء    
                                            </h4> 
                                        </div>
        
                                        <!-- Dropdown Button --> 
                                        <!-- End Dropdown Button -->
                                    </div>
        
                                    <div class="table-responsive mt-n2">
                                        <table class="style--two">
                                            <thead>
                                                <tr>
                                                    <th>id</th>
                                                    <th>اسم المستند</th>
                                                    <th>المالك</th>
                                                    <th>العقار</th>
                                                    <th>الحالة</th>
                                                    <th>عدد الايام المتبقية</th>
                                                    <th>تاريخ الانتهاء</th>
                                                    <td></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($documents as $document)
                                                    @php($building = $document->building)
                                                    <tr>
                                                        <td>
                                                            {{ $document->id }}
                                                        </td>
                                                        <td>
                                                            {{ $document->file_name }}
                                                        </td>
                                                        <td>
                                                            @if($building && $building->owner && $building->owner->user)
                                                                {{ $building->owner ? $building->owner->user->fullName : '' }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{route('admin.buildings.show',$document->building_id)}}">{{ $document->building_id }}</a>
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-{{ $document->status ? \App\Models\buildingDocument::STATUS_BADGE_SELECT[$document->status] : '' }}">
                                                                {{ $document->status ? \App\Models\buildingDocument::STATUS_SELECT[$document->status] : '' }}
                                                            </span>
                                                        </td>
                                                        <td>
                                                            @if($document->file_date_end && $document->file_date_end > date('Y-m-d'))
                                                                @php( $days = date_diff(new DateTime(\Carbon\Carbon::createFromFormat(config('panel.date_format'), $document->file_date_end)->format('Y-m-d')), new DateTime(date('Y-m-d')))->days)
                                                                @if($days >= 30)
                                                                    {{ $days}} أيام 
                                                                @else
                                                                    <span class="badge badge-danger">
                                                                        {{ $days}} أيام 
                                                                    </span>
                                                                @endif 
                                                            @else
                                                                <span class="badge badge-danger">
                                                                    تم الأنتهاء 
                                                                </span>
                                                            @endif 
                                                        </td>
                                                        <td>
                                                            {{$document->file_date_end}} 
                                                            <br>
                                                            {{ $document->file_date_hijri_end }}
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('admin.building-documents.update_status', ['id' => $document->id, 'status' => 'renewed']) }}" class="btn btn-success">
                                                                أضافة جديد  
                                                            </a>
                                                            <a href="{{ route('admin.building-documents.update_status', ['id' => $document->id, 'status' => 'closed']) }}" class="btn btn-danger">
                                                                انهاء
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td>{{ __('No entries found') }}</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12"> 
                    <div class="card mb-30 shadow">
                        <div class="card-body">
                            <h3>{!! $chart6->options['chart_title'] !!}</h3>
                            {!! $chart6->renderHtml() !!} 
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <!-- Card -->
                    <div class="card mb-30 shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div class="title-content mb-5">
                                    <h4 class="mb-2">
                                        أحدث الإضافات
                                    </h4> 
                                </div>

                                <!-- Dropdown Button -->
                                <div class="dropdown-button">
                                    <a href="#" class="d-flex align-items-center" data-toggle="dropdown">
                                        <div class="menu-icon style--two mr-0 d-flex justify-content-center">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('admin.owners.index') }}">المزيد</a>
                                    </div>
                                </div>
                                <!-- End Dropdown Button -->
                            </div>

                            <div class="table-responsive mt-n2">
                                <table class="style--two">
                                    <thead>
                                        <tr>
                                            @foreach ($settings4['fields'] as $key => $value)
                                                <th>
                                                    {{ trans(sprintf('cruds.%s.fields.%s', $settings4['translation_key'] ?? 'pleaseUpdateWidget', $key)) }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($settings4['data'] as $entry)
                                            <tr>
                                                @foreach ($settings4['fields'] as $key => $value)
                                                    <td>
                                                        @if ($value === '')
                                                            {{ $entry->{$key} }}
                                                        @elseif(is_iterable($entry->{$key}))
                                                            @foreach ($entry->{$key} as $subEentry)
                                                                <span
                                                                    class="label label-info">{{ $subEentry->{$value} }}</span>
                                                            @endforeach
                                                        @else
                                                            {{ data_get($entry, $key . '.' . $value) }}
                                                        @endif
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="{{ count($settings4['fields']) }}">
                                                    {{ __('No entries found') }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End Card -->
                </div>

                <div class="col-md-6">
                    <!-- Card -->
                    <div class="card todo-list mb-30 shadow">
                        <div class="card-body p-0">
                            <!-- Todo Single -->
                            <div class="single-row border-bottom pt-3 pb-2">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="">
                                        <h4 class="card-title">
                                            الإشعارات
                                        </h4>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="dropdown-button">
                                            <a href="#" class="d-flex align-items-center" data-toggle="dropdown">
                                                <div class="menu-icon style--two justify-content-center mr-0">
                                                    <span></span>
                                                    <span></span>
                                                    <span></span>
                                                </div>
                                            </a>
                                            <div class="dropdown-menu">
                                                <a href="#">عرض الكل</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Todo Single -->

                            <!-- Todo Single -->
                            
                            @forelse($settings5['data'] as $entry)
                                <div class="single-row border-bottom pt-3 pb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex position-relative">
                                            <!-- Todo Text -->
                                            <div class="todo-text">
                                                <p class="card-text mb-1">
                                                    @foreach ($settings5['fields'] as $key => $value)
                                                        @if ($value === '')
                                                            {{ $entry->{$key} }}
                                                        @elseif(is_iterable($entry->{$key}))
                                                            @foreach ($entry->{$key} as $subEentry)
                                                                <span
                                                                    class="label label-info">{{ $subEentry->{$value} }}</span>
                                                            @endforeach
                                                        @else
                                                            {{ data_get($entry, $key . '.' . $value) }}
                                                        @endif
                                                    @endforeach
                                                </p>
                                            </div>
                                            <!-- End Todo Text -->
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="single-row border-bottom pt-3 pb-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex position-relative">
                                            <!-- Todo Text -->
                                            <div class="todo-text">
                                                <p class="card-text mb-1">
                                                    {{ __('No entries found') }}
                                                </p>
                                            </div>
                                            <!-- End Todo Text -->
                                        </div>
                                    </div>
                                </div>
                            @endforelse
                            <!-- End Todo Single --> 
                        </div>
                    </div>
                    <!-- End Card -->
                </div>
            </div>
        </div>
    </div>
@endsection 
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>{!! $chart6->renderJs() !!} 
@endsection
