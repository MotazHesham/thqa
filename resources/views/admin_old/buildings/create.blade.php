@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.building.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.buildings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="owner_id">{{ trans('cruds.building.fields.owner') }}</label>
                <select class="form-control select2 {{ $errors->has('owner') ? 'is-invalid' : '' }}" name="owner_id" id="owner_id" required>
                    @foreach($owners as $id => $entry)
                        <option value="{{ $id }}" {{ old('owner_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('owner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('owner') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.owner_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.building.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="map_lat">{{ trans('cruds.building.fields.map_lat') }}</label>
                <input class="form-control {{ $errors->has('map_lat') ? 'is-invalid' : '' }}" type="text" name="map_lat" id="map_lat" value="{{ old('map_lat', '') }}" required>
                @if($errors->has('map_lat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('map_lat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.map_lat_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="map_long">{{ trans('cruds.building.fields.map_long') }}</label>
                <input class="form-control {{ $errors->has('map_long') ? 'is-invalid' : '' }}" type="text" name="map_long" id="map_long" value="{{ old('map_long', '') }}" required>
                @if($errors->has('map_long'))
                    <div class="invalid-feedback">
                        {{ $errors->first('map_long') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.map_long_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.building.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}">
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.building.fields.building_type') }}</label>
                <select class="form-control {{ $errors->has('building_type') ? 'is-invalid' : '' }}" name="building_type" id="building_type" required>
                    <option value disabled {{ old('building_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Building::BUILDING_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('building_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('building_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('building_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.building_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.building.fields.building_status') }}</label>
                <select class="form-control {{ $errors->has('building_status') ? 'is-invalid' : '' }}" name="building_status" id="building_status" required>
                    <option value disabled {{ old('building_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Building::BUILDING_STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('building_status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('building_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('building_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.building_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="owned_date">{{ trans('cruds.building.fields.owned_date') }}</label>
                <input class="form-control date {{ $errors->has('owned_date') ? 'is-invalid' : '' }}" type="text" name="owned_date" id="owned_date" value="{{ old('owned_date') }}" required>
                @if($errors->has('owned_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('owned_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.owned_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="registration_date">{{ trans('cruds.building.fields.registration_date') }}</label>
                <input class="form-control date {{ $errors->has('registration_date') ? 'is-invalid' : '' }}" type="text" name="registration_date" id="registration_date" value="{{ old('registration_date') }}" required>
                @if($errors->has('registration_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('registration_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.registration_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="survey_descision">{{ trans('cruds.building.fields.survey_descision') }}</label>
                <input class="form-control {{ $errors->has('survey_descision') ? 'is-invalid' : '' }}" type="text" name="survey_descision" id="survey_descision" value="{{ old('survey_descision', '') }}">
                @if($errors->has('survey_descision'))
                    <div class="invalid-feedback">
                        {{ $errors->first('survey_descision') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.survey_descision_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="commerical_num">{{ trans('cruds.building.fields.commerical_num') }}</label>
                <input class="form-control {{ $errors->has('commerical_num') ? 'is-invalid' : '' }}" type="text" name="commerical_num" id="commerical_num" value="{{ old('commerical_num', '') }}">
                @if($errors->has('commerical_num'))
                    <div class="invalid-feedback">
                        {{ $errors->first('commerical_num') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.commerical_num_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="real_estate_identity">{{ trans('cruds.building.fields.real_estate_identity') }}</label>
                <input class="form-control {{ $errors->has('real_estate_identity') ? 'is-invalid' : '' }}" type="text" name="real_estate_identity" id="real_estate_identity" value="{{ old('real_estate_identity', '') }}">
                @if($errors->has('real_estate_identity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('real_estate_identity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.real_estate_identity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photos">{{ trans('cruds.building.fields.photos') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photos') ? 'is-invalid' : '' }}" id="photos-dropzone">
                </div>
                @if($errors->has('photos'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photos') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.photos_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="employee_id">{{ trans('cruds.building.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id">
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="country_id">{{ trans('cruds.building.fields.country') }}</label>
                <select class="form-control select2 {{ $errors->has('country') ? 'is-invalid' : '' }}" name="country_id" id="country_id">
                    @foreach($countries as $id => $entry)
                        <option value="{{ $id }}" {{ old('country_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('country'))
                    <div class="invalid-feedback">
                        {{ $errors->first('country') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.country_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="city_id">{{ trans('cruds.building.fields.city') }}</label>
                <select class="form-control select2 {{ $errors->has('city') ? 'is-invalid' : '' }}" name="city_id" id="city_id">
                    @foreach($cities as $id => $entry)
                        <option value="{{ $id }}" {{ old('city_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('city'))
                    <div class="invalid-feedback">
                        {{ $errors->first('city') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.building.fields.city_helper') }}</span>
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

@section('scripts')
<script>
    var uploadedPhotosMap = {}
Dropzone.options.photosDropzone = {
    url: '{{ route('admin.buildings.storeMedia') }}',
    maxFilesize: 4, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 4,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="photos[]" value="' + response.name + '">')
      uploadedPhotosMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPhotosMap[file.name]
      }
      $('form').find('input[name="photos[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($building) && $building->photos)
      var files = {!! json_encode($building->photos) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="photos[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}

</script>
@endsection