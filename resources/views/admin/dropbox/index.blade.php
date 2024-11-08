@if($path != '')
    <button class="btn btn-warning" onclick="openDropBoxByPath('{{$prev}}',null,'{{$modal_id}}')"><-</button>
@endif
<div class="row">
    @foreach($folders as $folder)
        <div class="col-md-2">
            <div class="card text-center card-folder">
                <i class="@if($folder['tag'] == 'folder') icofont-ui-folder @else icofont-ui-file @endif"
                    @if($folder['tag'] == 'folder') onclick="openDropBoxByPath('{{$folder['id']}}','{{$path}}','{{$modal_id}}')" 
                    @elseif($folder['tag'] == 'file') ondblclick="selectedDropBoxFile('{{$folder['id']}}','{{$folder['name']}}','{{$modal_id}}')" @endif
                    style="font-size: 50px;color:black"></i>
                {{ $folder['name'] }}
            </div>
        </div>
    @endforeach
</div>