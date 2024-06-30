@can('building_document_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.building-documents.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.buildingDocument.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.buildingDocument.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-buildingBuildingDocuments">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.building') }}
                        </th>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.file_num') }}
                        </th>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.file_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.file_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.file_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.buildingDocument.fields.photo') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buildingDocuments as $key => $buildingDocument)
                        <tr data-entry-id="{{ $buildingDocument->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $buildingDocument->id ?? '' }}
                            </td>
                            <td>
                                {{ $buildingDocument->building->building_status ?? '' }}
                            </td>
                            <td>
                                {{ $buildingDocument->file_num ?? '' }}
                            </td>
                            <td>
                                {{ $buildingDocument->file_name ?? '' }}
                            </td>
                            <td>
                                {{ $buildingDocument->file_type ?? '' }}
                            </td>
                            <td>
                                {{ $buildingDocument->file_date ?? '' }}
                            </td>
                            <td>
                                @if($buildingDocument->photo)
                                    <a href="{{ $buildingDocument->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $buildingDocument->photo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('building_document_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.building-documents.show', $buildingDocument->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('building_document_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.building-documents.edit', $buildingDocument->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('building_document_delete')
                                    <form action="{{ route('admin.building-documents.destroy', $buildingDocument->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('building_document_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.building-documents.massDestroy') }}",
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
  let table = $('.datatable-buildingBuildingDocuments:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection