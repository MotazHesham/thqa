@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.buildingDocument.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.building-documents.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="building_id">{{ trans('cruds.buildingDocument.fields.building') }}</label>
                <select class="form-control select2 {{ $errors->has('building') ? 'is-invalid' : '' }}" name="building_id" id="building_id">
                    @foreach($buildings as $id => $entry)
                        <option value="{{ $id }}" {{ old('building_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('building'))
                    <div class="invalid-feedback">
                        {{ $errors->first('building') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.buildingDocument.fields.building_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file_num">{{ trans('cruds.buildingDocument.fields.file_num') }}</label>
                <input class="form-control {{ $errors->has('file_num') ? 'is-invalid' : '' }}" type="text" name="file_num" id="file_num" value="{{ old('file_num', '') }}">
                @if($errors->has('file_num'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file_num') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.buildingDocument.fields.file_num_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file_name">{{ trans('cruds.buildingDocument.fields.file_name') }}</label>
                <input class="form-control {{ $errors->has('file_name') ? 'is-invalid' : '' }}" type="text" name="file_name" id="file_name" value="{{ old('file_name', '') }}">
                @if($errors->has('file_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.buildingDocument.fields.file_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file_type">{{ trans('cruds.buildingDocument.fields.file_type') }}</label>
                <input class="form-control {{ $errors->has('file_type') ? 'is-invalid' : '' }}" type="text" name="file_type" id="file_type" value="{{ old('file_type', '') }}">
                @if($errors->has('file_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.buildingDocument.fields.file_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="file_date">{{ trans('cruds.buildingDocument.fields.file_date') }}</label>
                <input class="form-control date {{ $errors->has('file_date') ? 'is-invalid' : '' }}" type="text" name="file_date" id="file_date" value="{{ old('file_date') }}">
                @if($errors->has('file_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('file_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.buildingDocument.fields.file_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans('cruds.buildingDocument.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.buildingDocument.fields.photo_helper') }}</span>
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
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.building-documents.storeMedia') }}',
    maxFilesize: 4, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
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
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($buildingDocument) && $buildingDocument->photo)
      var file = {!! json_encode($buildingDocument->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
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