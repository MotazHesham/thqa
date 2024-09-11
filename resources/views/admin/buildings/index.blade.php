@extends('layouts.admin')
@section('content')
    <div class="main-content d-flex flex-column flex-md-row">
        <div class="container-fluid">


            <div class="row">
                <div class="col-12">
                    <!-- Card -->
                    <div class="card bg-transparent">
                        <!-- Contact Header -->
                        <div
                            class="contact-header d-flex align-items-sm-center media flex-column flex-sm-row bg-white mb-30">
                            <div class="contact-header-left media-body d-flex align-items-center ml-4">
                                <!-- Add New Contact Btn -->
                                <div class="add-new-contact ml-20">
                                    @can('building_create')
                                        <a href="{{ route('admin.buildings.create') }}" class="btn-circle"> 
                                            <img src="{{ asset('assets/img/svg/plus_white.svg') }}" alt="" class="svg">
                                        </a>
                                    @endcan
                                </div>
                                <!-- End Add New Contact Btn -->
                                <!-- Search Form -->
                                <form action="#" class="search-form flex-grow">
                                    <div class="theme-input-group style--two">
                                        <input type="text" name="search" value="{{ request('search') ?? '' }}"  class="theme-input-style" placeholder="بحث">

                                        <button type="submit"><img src="{{ asset('assets/img/svg/search-icon.svg') }}" alt=""
                                                class="svg"></button>
                                    </div>


                                </form>
                                <!-- End Search Form -->
                            </div>

                            <div class="contact-header-right d-flex align-items-center justify-content-end mt-3 mt-sm-0">


                                <!-- Delete Mail -->
                                <div class="delete_mail">
                                    <a href="#" onclick="delete_records()"><img src="{{ asset('assets/img/svg/delete.svg') }}" alt=""
                                            class="svg"></a>
                                </div>
                                <!-- End Delete Mail -->
                                <!-- Pagination -->
                                <div class="pagination style--two d-flex flex-column align-items-center ml-n2">
                                    <ul class="list-inline d-inline-flex align-items-center">
                                        <li>
                                            <a href="{{$buildings->nextPageUrl() ?? ''}}">
                                                <img src="{{ asset('assets/img/svg/left-angle.svg') }}" alt="" class="svg">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{$buildings->previousPageUrl() ?? ''}}" class="current">
                                                <img src="{{ asset('assets/img/svg/right-angle.svg') }}" alt="" class="svg">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Pagination -->
                            </div>
                        </div>
                        <!-- End Contact Header -->


                        <div class="table-responsive">
                            <!-- Invoice List Table --> 
                            <table class="contact-list-table text-nowrap bg-white">
                                <thead>
                                    <tr>
                                        <th>
                                            <!-- Custom Checkbox -->
                                            <label class="custom-checkbox">
                                                <input type="checkbox">
                                                <span class="checkmark"></span>
                                            </label>
                                            <!-- End Custom Checkbox -->

                                        </th>
                                        <th>الكود</th>
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
                                            <td>
                                                <!-- Custom Checkbox -->
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" name="ids[]" value="{{ $building->id }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <!-- End Custom Checkbox -->

                                            </td>
                                            <td>{{ $building->code }}</td>
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
                                                {{-- <td> <a href="#">{{ $building->employee->fullName ?? '' }}</a></td>  --}}
                                                <td>
                                                    @foreach ($building->employees as $employee)
                                                        <span class="badge badge-info">{{ $employee->fullName ?? '' }}</span>
                                                    @endforeach
                                                </td>
                                            @endif
                                            <td class="actions">
                                                <a href="{{$building->get_location_link()}}" target="_blank"  > 
                                                    <svg height="25" viewBox="0 0 510.619 510.619" width="25" xmlns="http://www.w3.org/2000/svg"><path d="M431.92 184.11c0-25.88-5.56-50.46-15.56-72.6l-.01.01-161.54 114.195-73.97 156.335 30.97 42.79c3.08 4.25 5.55 8.9 7.35 13.83l19.04 52.28c5.93 16.3 29.02 16.2 34.83-.15l18.41-51.88c1.81-5.09 4.34-9.9 7.5-14.27l94.16-130.07h-.01c24.28-30.25 38.83-68.66 38.83-110.47z" fill="#00c89e"/><path d="M255 7.5c-53.21.09-101.05 23.99-133.41 61.54l77.97 66.7 65.914 9.803L305.02 14.6C289.16 9.95 272.37 7.47 255 7.5z" fill="#00abf2"/><path d="M305.02 14.6 151.923 190.465l92.799 118.204L416.35 111.52l.01-.01c-21.02-46.56-61.64-82.37-111.34-96.91z" fill="#00c3ff"/><path d="m296.127 424.84-30.97-42.79-50.99-70.437-33.327 70.437 30.97 42.79c3.08 4.25 5.55 8.9 7.35 13.83l19.04 52.28c5.93 16.3 29.02 16.2 34.83-.15l18.41-51.88a56.88 56.88 0 0 1 6.033-12.128 57.312 57.312 0 0 0-1.346-1.952z" fill="#00ab7e"/><path d="M121.59 69.04c-26.83 31.1-43.03 71.58-42.89 115.65.09 25.66 5.64 50.02 15.58 71.99l70.005-27.724 35.225-93.146.05-.07z" fill="#ff4f80"/><path d="M163.017 184.69c-.077-24.249 4.802-47.407 13.669-68.518L121.59 69.04c-26.83 31.1-43.03 71.58-42.89 115.65.09 25.66 5.64 50.02 15.58 71.99l70.005-27.724 2.749-7.27a177.258 177.258 0 0 1-4.017-36.996z" fill="#ff1146"/><path d="m311.11 232.4-111.6-96.59-33.467 38.441L94.28 256.68a176.234 176.234 0 0 0 23.25 37.9h-.01l63.32 87.47L311.11 232.4c-2.386 2.756 0 0 0 0z" fill="#ffdc5a"/><path d="M201.837 294.58h.01a176.234 176.234 0 0 1-23.25-37.9c-9.94-21.97-15.49-46.33-15.58-71.99-.008-2.382.042-4.751.129-7.111L94.28 256.68a176.234 176.234 0 0 0 23.25 37.9h-.01l63.32 87.47 46.034-52.883z" fill="#ffc027"/><g><path d="M199.51 135.81c13.53-15.63 33.51-25.51 55.8-25.51 40.76 0 73.8 33.05 73.8 73.81 0 18.47-6.78 35.35-18 48.29-13.53 15.63-33.51 25.51-55.8 25.51-40.76 0-73.8-33.04-73.8-73.8 0-18.47 6.78-35.35 18-48.3z" fill="#fff"/></g><path d="M205.907 69.04c23.617-27.405 55.486-47.526 91.664-56.44A176.89 176.89 0 0 0 255 7.5c-53.21.09-101.05 23.99-133.41 61.54l55.096 47.132a177.282 177.282 0 0 1 29.221-47.132z" fill="#008cc9"/><path d="M423.196 108.424c-22.17-49.106-64.475-85.927-116.066-101.02C290.374 2.491 272.944 0 255.313 0h-.326c-53.334.09-104.026 23.47-139.076 64.141C86.938 97.726 71.06 140.546 71.2 184.717c.092 26.177 5.558 51.429 16.243 75.046a183.808 183.808 0 0 0 24.019 39.238l94.276 130.24a49.197 49.197 0 0 1 6.375 11.995l19.039 52.277c3.784 10.4 13.362 17.105 24.423 17.105h.103c11.113-.042 20.699-6.835 24.421-17.311l18.408-51.875a49.315 49.315 0 0 1 6.509-12.385l74.155-102.437a7.5 7.5 0 0 0-12.15-8.796l-74.158 102.439a64.39 64.39 0 0 0-8.491 16.157l-18.409 51.877c-1.913 5.383-6.597 7.316-10.342 7.33-1.803-.042-7.921-.494-10.374-7.235l-19.042-52.286a64.208 64.208 0 0 0-8.319-15.655l-27.478-37.961 38.632-44.379a7.5 7.5 0 0 0-.732-10.581 7.499 7.499 0 0 0-10.581.732l-36.347 41.754-57.576-79.54a7.238 7.238 0 0 0-.425-.584 168.955 168.955 0 0 1-20.23-31.968l71.277-81.87a81.308 81.308 0 0 0-.414 8.063c0 44.829 36.471 81.3 81.3 81.3 6.5 0 12.908-.781 19.106-2.279l-35.457 40.732a7.5 7.5 0 1 0 11.313 9.848l163.755-188.1c6.893 18.654 10.393 38.278 10.393 58.499 0 38.896-12.856 75.473-37.179 105.775a7.332 7.332 0 0 0-.422.581l-.817 1.128a7.5 7.5 0 1 0 12.149 8.799l1.007-1.39c25.965-32.479 40.26-73.265 40.26-114.89 0-26.386-5.459-51.851-16.224-75.686zM255.013 15a169.932 169.932 0 0 1 36.355 3.86l-27.715 31.836a7.5 7.5 0 1 0 11.313 9.848l32.507-37.34c43.805 14.165 79.864 45.552 100.022 87.064l-71.298 81.894c.265-2.666.413-5.352.413-8.053 0-44.834-36.471-81.31-81.3-81.31-6.504 0-12.915.782-19.116 2.282l17.778-20.421a7.5 7.5 0 0 0-11.313-9.85l-43.873 50.396-66.463-56.857c31.923-33.91 76.214-53.27 122.69-53.349zM86.2 184.667c-.121-38.07 12.725-75.054 36.316-104.964l66.426 56.824-92.335 106.058c-6.833-18.464-10.337-37.892-10.407-57.918zm102.81-.557a66.266 66.266 0 0 1 16.168-43.389l.002-.002a66.266 66.266 0 0 1 50.129-22.919c36.558 0 66.3 29.747 66.3 66.31a66.212 66.212 0 0 1-16.17 43.381 66.265 66.265 0 0 1-50.129 22.918c-36.558.001-66.3-29.741-66.3-66.299z"/></svg>
                                                </a>
                                                <a href="{{ route('admin.buildings.edit',$building->id) }}">
                                                    <img src="{{ asset('assets/img/svg/c-edit.svg') }}" alt="" class="svg">
                                                </a>
                                                @can('owner_delete')
                                                    <form action="{{ route('admin.buildings.destroy', $building->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                                                        <button type="submit" style="background: #ffffff00"> 
                                                            <img src="{{ asset('assets/img/svg/c-close.svg') }}" alt="" class="svg">
                                                        </button>
                                                    </form> 
                                                @endcan
                                            </td>
                                        </tr> 
                                    @endforeach
                                </tbody>
                            </table>
                            <!-- End Invoice List Table -->
                        </div> 
                    </div>
                    {{ $buildings->links() }} 
                    <!-- End Card --> 
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')  
    <script>
        function delete_records(){  
            let checkedValues = [];
            $('input[name="ids[]"]:checked').each(function() {
                checkedValues.push($(this).val());
            }); 
            if(checkedValues.length > 0){ 
                if(confirm('{{ trans('global.areYouSure') }}')){ 
                    $.ajax({ 
                        method: 'POST',
                        url: '{{ route("admin.buildings.massDestroy") }}',
                        data: { 
                            ids: checkedValues, 
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE' 
                        }
                    }).done(function () { location.reload() })
                }
            }else{
                alert('Please select at least one record to delete');
            }

        }
    </script>
@endsection
