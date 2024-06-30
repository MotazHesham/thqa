@extends('layouts.admin')
@section('content')
@can('building_sak_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.building-saks.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.buildingSak.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.buildingSak.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-BuildingSak">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.buildingSak.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.buildingSak.fields.building') }}
                        </th>
                        <th>
                            {{ trans('cruds.buildingSak.fields.sak_num') }}
                        </th>
                        <th>
                            {{ trans('cruds.buildingSak.fields.photo') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buildingSaks as $key => $buildingSak)
                        <tr data-entry-id="{{ $buildingSak->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $buildingSak->id ?? '' }}
                            </td>
                            <td>
                                {{ $buildingSak->building->building_status ?? '' }}
                            </td>
                            <td>
                                {{ $buildingSak->sak_num ?? '' }}
                            </td>
                            <td>
                                @if($buildingSak->photo)
                                    <a href="{{ $buildingSak->photo->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $buildingSak->photo->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @can('building_sak_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.building-saks.show', $buildingSak->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('building_sak_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.building-saks.edit', $buildingSak->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('building_sak_delete')
                                    <form action="{{ route('admin.building-saks.destroy', $buildingSak->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('building_sak_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.building-saks.massDestroy') }}",
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
  let table = $('.datatable-BuildingSak:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection