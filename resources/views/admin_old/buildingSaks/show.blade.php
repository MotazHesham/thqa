@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.buildingSak.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.building-saks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingSak.fields.id') }}
                        </th>
                        <td>
                            {{ $buildingSak->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingSak.fields.building') }}
                        </th>
                        <td>
                            {{ $buildingSak->building->building_status ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingSak.fields.sak_num') }}
                        </th>
                        <td>
                            {{ $buildingSak->sak_num }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.buildingSak.fields.photo') }}
                        </th>
                        <td>
                            @if($buildingSak->photo)
                                <a href="{{ $buildingSak->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $buildingSak->photo->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.building-saks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection