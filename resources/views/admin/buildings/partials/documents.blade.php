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
                        <th>رقم المستند</th>
                        <th>اسم المستند</th>
                        <th>نوع المستند</th>
                        <th>التاريخ </th>
                        <th>التاريخ هجري</th>
                        <th>الحالة</th>
                        @if(!$folder)
                            <th>المجلد</th>
                        @endif
                        <th>عرض</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                        <tr>
                            <td>{{ $document->file_num }}</td>
                            <td>{{ $document->file_name }}</td>
                            <td>{{ $document->file_type }}</td>
                            <td>{{ $document->file_date }} <br> {{ $document->file_date_end }}
                            </td>
                            <td>{{ $document->file_date_hijri }} <br>
                                {{ $document->file_date_hijri_end }}</td>
                            <td>
                                <span
                                    class="badge badge-{{ $document->status ? \App\Models\buildingDocument::STATUS_BADGE_SELECT[$document->status] : '' }}">
                                    {{ $document->status ? \App\Models\buildingDocument::STATUS_SELECT[$document->status] : '' }}
                                </span>

                            </td>
                            @if(!$folder)
                                <td>
                                    <div class="form-group">
                                        <select name="" id="" class="form-control" onchange="update_folder(this,'{{ $document->id }}')">
                                            <option value="">اختر المجلد</option>
                                            @foreach($folders as $raw)
                                                <option value="{{ $raw->id }}" @if($document->building_folder_id == $raw->id) selected @endif>{{ $raw->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </td>
                            @endif
                            <td>
                                @if($document->photo)
                                    <a href="{{ $document->photo->getUrl() }}"
                                        class="details-btn">عرض
                                    </a>
                                @endif 
                                @if($document->dropbox_id)
                                    <a target="_blanc" href="{{ route('admin.dropbox.getDropBoxFileLink',$document->dropbox_id ?? 0) }}"class="details-btn">عرض</a>
                                @endif
                                <form
                                    action="{{ route('admin.building-documents.destroy', $document->id) }}"
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
    function update_folder(e,document_id){  
        $.post('{{ route('admin.building-folders.update_folder') }}', {
            _token: '{{ csrf_token() }}', 
            document_id: document_id, 
            type: 'document', 
            building_folder_id: $(e).val(), 
        }, function(data) {
            
        });
    }
</script>