<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBuildingSakRequest;
use App\Http\Requests\StoreBuildingSakRequest;
use App\Http\Requests\UpdateBuildingSakRequest;
use App\Models\Building;
use App\Models\BuildingSak;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BuildingSaksController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('building_sak_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildingSaks = BuildingSak::with(['building', 'media'])->get();

        return view('admin.buildingSaks.index', compact('buildingSaks'));
    }

    public function create()
    {
        abort_if(Gate::denies('building_sak_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildings = Building::pluck('building_status', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.buildingSaks.create', compact('buildings'));
    }

    public function store(StoreBuildingSakRequest $request)
    {
        $buildingSak = BuildingSak::create($request->all());

        if ($request->input('photo', false)) {
            $buildingSak->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $buildingSak->id]);
        }

        return redirect()->route('admin.building-saks.index');
    }

    public function edit(BuildingSak $buildingSak)
    {
        abort_if(Gate::denies('building_sak_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildings = Building::pluck('building_status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $buildingSak->load('building');

        return view('admin.buildingSaks.edit', compact('buildingSak', 'buildings'));
    }

    public function update(UpdateBuildingSakRequest $request, BuildingSak $buildingSak)
    {
        $buildingSak->update($request->all());

        if ($request->input('photo', false)) {
            if (! $buildingSak->photo || $request->input('photo') !== $buildingSak->photo->file_name) {
                if ($buildingSak->photo) {
                    $buildingSak->photo->delete();
                }
                $buildingSak->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($buildingSak->photo) {
            $buildingSak->photo->delete();
        }

        return redirect()->route('admin.building-saks.index');
    }

    public function show(BuildingSak $buildingSak)
    {
        abort_if(Gate::denies('building_sak_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildingSak->load('building');

        return view('admin.buildingSaks.show', compact('buildingSak'));
    }

    public function destroy(BuildingSak $buildingSak)
    {
        abort_if(Gate::denies('building_sak_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildingSak->delete();

        return back();
    }

    public function massDestroy(MassDestroyBuildingSakRequest $request)
    {
        $buildingSaks = BuildingSak::find(request('ids'));

        foreach ($buildingSaks as $buildingSak) {
            $buildingSak->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('building_sak_create') && Gate::denies('building_sak_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BuildingSak();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
