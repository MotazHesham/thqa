@extends('layouts.admin')
@section('content')

    <div class="main-content d-flex flex-column flex-md-row" style="overflow: visible">
        <div class="container-fluid">
            <div class="card mb-30 p-4">
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
                <form method="POST" action="{{ route('admin.user-alerts.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="alert_text">{{ trans('cruds.userAlert.fields.alert_text') }}</label>
                        <input class="form-control {{ $errors->has('alert_text') ? 'is-invalid' : '' }}" type="text"
                            name="alert_text" id="alert_text" value="{{ old('alert_text', '') }}" required>
                        @if ($errors->has('alert_text'))
                            <div class="invalid-feedback">
                                {{ $errors->first('alert_text') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.userAlert.fields.alert_text_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="alert_link">{{ trans('cruds.userAlert.fields.alert_link') }}</label>
                        <input class="form-control {{ $errors->has('alert_link') ? 'is-invalid' : '' }}" type="text"
                            name="alert_link" id="alert_link" value="{{ old('alert_link', '') }}">
                        @if ($errors->has('alert_link'))
                            <div class="invalid-feedback">
                                {{ $errors->first('alert_link') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.userAlert.fields.alert_link_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="users">{{ trans('cruds.userAlert.fields.user') }}</label>
                        <div style="padding-bottom: 4px">
                            <span class="btn btn-info btn-xs select-all"
                                style="border-radius: 0">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-xs deselect-all"
                                style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]"
                            id="users" multiple>
                            @foreach ($users as $id => $user)
                                <option value="{{ $id }}"
                                    {{ in_array($id, old('users', [])) ? 'selected' : '' }}>{{ $user }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('users'))
                            <div class="invalid-feedback">
                                {{ $errors->first('users') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.userAlert.fields.user_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans('global.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection
