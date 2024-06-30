@can('building_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.buildings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.building.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.building.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ownerBuildings">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.building.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.owner') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.map_lat') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.map_long') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.building_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.building_status') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.owned_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.registration_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.survey_descision') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.commerical_num') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.real_estate_identity') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.photos') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.country') }}
                        </th>
                        <th>
                            {{ trans('cruds.building.fields.city') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buildings as $key => $building)
                        <tr data-entry-id="{{ $building->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $building->id ?? '' }}
                            </td>
                            <td>
                                {{ $building->owner->identity_num ?? '' }}
                            </td>
                            <td>
                                {{ $building->name ?? '' }}
                            </td>
                            <td>
                                {{ $building->map_lat ?? '' }}
                            </td>
                            <td>
                                {{ $building->map_long ?? '' }}
                            </td>
                            <td>
                                {{ $building->address ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Building::BUILDING_TYPE_SELECT[$building->building_type] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Building::BUILDING_STATUS_SELECT[$building->building_status] ?? '' }}
                            </td>
                            <td>
                                {{ $building->owned_date ?? '' }}
                            </td>
                            <td>
                                {{ $building->registration_date ?? '' }}
                            </td>
                            <td>
                                {{ $building->survey_descision ?? '' }}
                            </td>
                            <td>
                                {{ $building->commerical_num ?? '' }}
                            </td>
                            <td>
                                {{ $building->real_estate_identity ?? '' }}
                            </td>
                            <td>
                                @foreach($building->photos as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ $building->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $building->country->name ?? '' }}
                            </td>
                            <td>
                                {{ $building->city->name ?? '' }}
                            </td>
                            <td>
                                @can('building_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.buildings.show', $building->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('building_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.buildings.edit', $building->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('building_delete')
                                    <form action="{{ route('admin.buildings.destroy', $building->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('building_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.buildings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  });
  let table = $('.datatable-ownerBuildings:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection