@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.owner.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.owners.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.id') }}
                        </th>
                        <td>
                            {{ $owner->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.user') }}
                        </th>
                        <td>
                            {{ $owner->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.gender') }}
                        </th>
                        <td>
                            {{ App\Models\Owner::GENDER_SELECT[$owner->gender] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.identity_num') }}
                        </th>
                        <td>
                            {{ $owner->identity_num }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.identity_date') }}
                        </th>
                        <td>
                            {{ $owner->identity_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.address') }}
                        </th>
                        <td>
                            {{ $owner->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.commerical_num') }}
                        </th>
                        <td>
                            {{ $owner->commerical_num }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.owner.fields.real_estate_identity') }}
                        </th>
                        <td>
                            {{ $owner->real_estate_identity }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.owners.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#owner_buildings" role="tab" data-toggle="tab">
                {{ trans('cruds.building.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="owner_buildings">
            @includeIf('admin.owners.relationships.ownerBuildings', ['buildings' => $owner->ownerBuildings])
        </div>
    </div>
</div>

@endsection