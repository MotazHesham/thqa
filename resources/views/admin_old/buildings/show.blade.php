@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.building.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.buildings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.id') }}
                        </th>
                        <td>
                            {{ $building->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.owner') }}
                        </th>
                        <td>
                            {{ $building->owner->identity_num ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.name') }}
                        </th>
                        <td>
                            {{ $building->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.map_lat') }}
                        </th>
                        <td>
                            {{ $building->map_lat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.map_long') }}
                        </th>
                        <td>
                            {{ $building->map_long }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.address') }}
                        </th>
                        <td>
                            {{ $building->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.building_type') }}
                        </th>
                        <td>
                            {{ App\Models\Building::BUILDING_TYPE_SELECT[$building->building_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.building_status') }}
                        </th>
                        <td>
                            {{ App\Models\Building::BUILDING_STATUS_SELECT[$building->building_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.owned_date') }}
                        </th>
                        <td>
                            {{ $building->owned_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.registration_date') }}
                        </th>
                        <td>
                            {{ $building->registration_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.survey_descision') }}
                        </th>
                        <td>
                            {{ $building->survey_descision }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.commerical_num') }}
                        </th>
                        <td>
                            {{ $building->commerical_num }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.real_estate_identity') }}
                        </th>
                        <td>
                            {{ $building->real_estate_identity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.photos') }}
                        </th>
                        <td>
                            @foreach($building->photos as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.employee') }}
                        </th>
                        <td>
                            {{ $building->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.country') }}
                        </th>
                        <td>
                            {{ $building->country->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.building.fields.city') }}
                        </th>
                        <td>
                            {{ $building->city->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.buildings.index') }}">
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
            <a class="nav-link" href="#building_building_documents" role="tab" data-toggle="tab">
                {{ trans('cruds.buildingDocument.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="building_building_documents">
            @includeIf('admin.buildings.relationships.buildingBuildingDocuments', ['buildingDocuments' => $building->buildingBuildingDocuments])
        </div>
    </div>
</div>

@endsection