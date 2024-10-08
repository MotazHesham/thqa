@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.buildingSak.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.building-saks.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="building_id">{{ trans('cruds.buildingSak.fields.building') }}</label>
                <select class="form-control select2 {{ $errors->has('building') ? 'is-invalid' : '' }}" name="building_id" id="building_id" required>
                    @foreach($buildings as $id => $entry)
                        <option value="{{ $id }}" {{ old('building_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('building'))
                    <div class="invalid-feedback">
                        {{ $errors->first('building') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.buildingSak.fields.building_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="sak_num">{{ trans('cruds.buildingSak.fields.sak_num') }}</label>
                <input class="form-control {{ $errors->has('sak_num') ? 'is-invalid' : '' }}" type="text" name="sak_num" id="sak_num" value="{{ old('sak_num', '') }}" required>
                @if($errors->has('sak_num'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sak_num') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.buildingSak.fields.sak_num_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="photo">{{ trans('cruds.buildingSak.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.buildingSak.fields.photo_helper') }}</span>
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
    url: '{{ route('admin.building-saks.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
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
@if(isset($buildingSak) && $buildingSak->photo)
      var file = {!! json_encode($buildingSak->photo) !!}
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