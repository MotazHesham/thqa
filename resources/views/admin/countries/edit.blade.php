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
                <form method="POST" action="{{ route('admin.countries.update', [$country->id]) }}"
                    enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.country.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                            name="name" id="name" value="{{ old('name', $country->name) }}" required>
                        @if ($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.country.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="short_code">{{ trans('cruds.country.fields.short_code') }}</label>
                        <input class="form-control {{ $errors->has('short_code') ? 'is-invalid' : '' }}" type="text"
                            name="short_code" id="short_code" value="{{ old('short_code', $country->short_code) }}"
                            required>
                        @if ($errors->has('short_code'))
                            <div class="invalid-feedback">
                                {{ $errors->first('short_code') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.country.fields.short_code_helper') }}</span>
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
