@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.buildingDocument.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.building-documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.id') }}
                        </th>
                        <td>
                            {{ $buildingDocument->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.building') }}
                        </th>
                        <td>
                            {{ $buildingDocument->building->building_status ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.file_num') }}
                        </th>
                        <td>
                            {{ $buildingDocument->file_num }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.file_name') }}
                        </th>
                        <td>
                            {{ $buildingDocument->file_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.file_type') }}
                        </th>
                        <td>
                            {{ $buildingDocument->file_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.file_date') }}
                        </th>
                        <td>
                            {{ $buildingDocument->file_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.photo') }}
                        </th>
                        <td>
                            @if($buildingDocument->photo)
                                <a href="{{ $buildingDocument->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $buildingDocument->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.building-documents.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection