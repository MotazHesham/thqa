<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="AjaxModalLabel"> 
            @if($folder)
                <form action="{{ route('admin.building-folders.update',[$folder->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="folder_name">اسم المجلد</label>
                                <input type="text" class="form-control" name="name" value="{{ $folder->name }}" id="">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <br>
                            <div class="form-group">
                                <button class="btn btn-success">تعديل المجلد</button> 
                            </div>
                        </div>
                        <div class="col-md-4">
                            <br>
                            <div class="form-group"> 
                                <a class="btn btn-danger" style="background:rgb(255, 255, 255);color:black;border: 2px red solid;" href="{{ route('admin.building-folders.delete_folder',$folder->id) }}">حذف المجلد</a>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">x</button>
    </div>
    <div class="modal-body">
        <div class="table-responsive">
            <!-- Invoice List Table --> 
            <table class="text-nowrap table-contextual dh-table">
                <thead>
                    <tr>
                        <th>اسم الصك</th>
                        <th> التاريخ</th>
                        <th> التاريخ الهجري</th>
                        @if(!$folder)
                            <th>المجلد</th>
                        @endif
                        <th> </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saks as $sak)
                        <tr>
                            <td>{{ $sak->sak_num }}</td>
                            <td>{{ $sak->date }}</td>
                            <td>{{ $sak->date_hijri }}</td>
                            @if(!$folder)
                                <td>
                                    <div class="form-group">
                                        <select name="" id="" class="form-control" onchange="update_folder(this,'{{ $sak->id }}')">
                                            <option value="">اختر المجلد</option>
                                            @foreach($folders as $raw)
                                                <option value="{{ $raw->id }}" @if($sak->building_folder_id == $raw->id) selected @endif>{{ $raw->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            @endif
                            <td>
                                @if($sak->photo)
                                    <a href="{{ $sak->photo->getUrl() }}"
                                        class="details-btn">عرض
                                    </a> 
                                @endif
                                @if($sak->dropbox_id)
                                    <a target="_blanc" href="{{ route('admin.dropbox.getDropBoxFileLink',$sak->dropbox_id) }}"class="details-btn">عرض</a>
                                @endif
                                <form action="{{ route('admin.building-saks.destroy', $sak->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                    style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token"
                                        value="{{ csrf_token() }}">
                                    <button type="submit" style="background: #ffffff00">
                                        <img src="{{ asset('assets/img/svg/c-close.svg') }}"
                                            alt="" class="svg">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- End Invoice List Table -->
        </div>
    </div>
</div>

<script>
    function update_folder(e,sak_id){  
        $.post('{{ route('admin.building-folders.update_folder') }}', {
            _token: '{{ csrf_token() }}', 
            sak_id: sak_id, 
            type: 'sak',
            building_folder_id: $(e).val(), 
        }, function(data) {
            
        });
    }
</script>