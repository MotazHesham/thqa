@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.owner.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.owners.update", [$owner->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.owner.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $owner->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.owner.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.owner.fields.gender') }}</label>
                <select class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                    <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Owner::GENDER_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('gender', $owner->gender) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('gender'))
                    <div class="invalid-feedback">
                        {{ $errors->first('gender') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.owner.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="identity_num">{{ trans('cruds.owner.fields.identity_num') }}</label>
                <input class="form-control {{ $errors->has('identity_num') ? 'is-invalid' : '' }}" type="text" name="identity_num" id="identity_num" value="{{ old('identity_num', $owner->identity_num) }}">
                @if($errors->has('identity_num'))
                    <div class="invalid-feedback">
                        {{ $errors->first('identity_num') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.owner.fields.identity_num_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="identity_date">{{ trans('cruds.owner.fields.identity_date') }}</label>
                <input class="form-control date {{ $errors->has('identity_date') ? 'is-invalid' : '' }}" type="text" name="identity_date" id="identity_date" value="{{ old('identity_date', $owner->identity_date) }}">
                @if($errors->has('identity_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('identity_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.owner.fields.identity_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.owner.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $owner->address) }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.owner.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="commerical_num">{{ trans('cruds.owner.fields.commerical_num') }}</label>
                <input class="form-control {{ $errors->has('commerical_num') ? 'is-invalid' : '' }}" type="text" name="commerical_num" id="commerical_num" value="{{ old('commerical_num', $owner->commerical_num) }}">
                @if($errors->has('commerical_num'))
                    <div class="invalid-feedback">
                        {{ $errors->first('commerical_num') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.owner.fields.commerical_num_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="real_estate_identity">{{ trans('cruds.owner.fields.real_estate_identity') }}</label>
                <input class="form-control {{ $errors->has('real_estate_identity') ? 'is-invalid' : '' }}" type="text" name="real_estate_identity" id="real_estate_identity" value="{{ old('real_estate_identity', $owner->real_estate_identity) }}">
                @if($errors->has('real_estate_identity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('real_estate_identity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.owner.fields.real_estate_identity_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection