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
                                    @can('user_create')
                                        <a href="{{ route('admin.users.create') }}" class="btn-circle">
                                            <img src="{{ asset('assets/img/svg/plus_white.svg') }}" alt=""
                                                class="svg">
                                        </a>
                                    @endcan
                                </div>
                                <!-- End Add New Contact Btn -->
                                <!-- Search Form -->
                                <form class="search-form flex-grow">
                                    <div class="theme-input-group style--two">
                                        <input type="text" name="search" value="{{ request('search') ?? '' }}"
                                            class="theme-input-style" placeholder="بحث">

                                        <button type="submit"><img src="{{ asset('assets/img/svg/search-icon.svg') }}"
                                                alt="" class="svg"></button>
                                    </div>


                                </form>
                                <!-- End Search Form -->
                            </div>

                            <div class="contact-header-right d-flex align-items-center justify-content-end mt-3 mt-sm-0">


                                <!-- Delete Mail -->
                                <div class="delete_mail">
                                    <a href="#" onclick="delete_records()"><img
                                            src="{{ asset('assets/img/svg/delete.svg') }}" alt=""
                                            class="svg"></a>
                                </div>
                                <!-- End Delete Mail -->
                                <!-- Pagination -->
                                <div class="pagination style--two d-flex flex-column align-items-center ml-n2">
                                    <ul class="list-inline d-inline-flex align-items-center">
                                        <li>
                                            <a href="{{ $users->nextPageUrl() ?? '' }}">
                                                <img src="{{ asset('assets/img/svg/left-angle.svg') }}" alt=""
                                                    class="svg">
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ $users->previousPageUrl() ?? '' }}" class="current">
                                                <img src="{{ asset('assets/img/svg/right-angle.svg') }}" alt=""
                                                    class="svg">
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
                                        <th>الاسم </th>
                                        <th>البريد الإلكتروني</th>
                                        <th>الجوال</th> 
                                        <th>الصلاحيات</th> 
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr data-entry-id="{{ $user->id }}">
                                            <td>
                                                <!-- Custom Checkbox -->
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" name="ids[]" value="{{ $user->id }}">
                                                    <span class="checkmark"></span>
                                                </label>
                                                <!-- End Custom Checkbox -->

                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="img ml-20">
                                                        <img src="{{ $user->photo ? $user->photo->getUrl('thumb') : asset('assets/img/avatar/user0.png') }}"
                                                            class="img-40" alt="">
                                                    </div>
                                                    <div class="name bold">
                                                        <a href="#"> {{ $user->fullName ?? '' }}  </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email ?? '' }}</td>
                                            <td>{{ $user->phone ?? '' }} </td>
                                            <td>
                                                @foreach($user->roles as $key => $item)
                                                    <span class="badge badge-info">{{ $item->title }}</span>
                                                @endforeach
                                            </td> 
                                            <td class="actions">
                                                @can('user_edit')
                                                    <a href="{{ route('admin.users.edit', $user->id) }}">
                                                        <img src="{{ asset('assets/img/svg/c-edit.svg') }}" alt=""
                                                            class="svg">
                                                    </a>
                                                @endcan
                                                @can('user_delete')
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                        style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" style="background: #ffffff00">
                                                            <img src="{{ asset('assets/img/svg/c-close.svg') }}" alt=""
                                                                class="svg">
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/custom-datepicker.js') }}"></script>
    <!-- ======= End BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS ======= -->
    <script>
        function delete_records() {
            let checkedValues = [];
            $('input[name="ids[]"]:checked').each(function() {
                checkedValues.push($(this).val());
            });
            if (checkedValues.length > 0) {
                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        method: 'POST',
                        url: '{{ route('admin.users.massDestroy') }}',
                        data: {
                            ids: checkedValues,
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        }
                    }).done(function() {
                        location.reload()
                    })
                }
            } else {
                alert('Please select at least one record to delete');
            }

        }
    </script>
@endsection
