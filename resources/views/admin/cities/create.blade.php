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
                <form method="POST" action="{{ route('admin.cities.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.city.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                            name="name" id="name" value="{{ old('name', '') }}" required>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.city.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="country_id">{{ trans('cruds.city.fields.country') }}</label>
                        <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}"
                            name="country_id" id="country_id" required>
                            @foreach ($countries as $id => $entry)
                                <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>
                                    {{ $entry }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country'))
                            <div class="invalid-feedback">
                                {{ $errors->first('country') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.city.fields.country_helper') }}</span>
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
