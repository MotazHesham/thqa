<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBuildingDocumentRequest;
use App\Http\Requests\StoreBuildingDocumentRequest;
use App\Http\Requests\UpdateBuildingDocumentRequest;
use App\Models\Building;
use App\Models\BuildingDocument;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BuildingDocumentsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('building_document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildingDocuments = BuildingDocument::with(['building', 'media'])->get();

        return view('admin.buildingDocuments.index', compact('buildingDocuments'));
    }

    public function create()
    {
        abort_if(Gate::denies('building_document_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildings = Building::pluck('building_status', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.buildingDocuments.create', compact('buildings'));
    }

    public function store(StoreBuildingDocumentRequest $request)
    {
        $buildingDocument = BuildingDocument::create($request->all());

        if ($request->input('photo', false)) {
            $buildingDocument->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $buildingDocument->id]);
        }

        return redirect()->route('admin.building-documents.index');
    }

    public function edit(BuildingDocument $buildingDocument)
    {
        abort_if(Gate::denies('building_document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildings = Building::pluck('building_status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $buildingDocument->load('building');

        return view('admin.buildingDocuments.edit', compact('buildingDocument', 'buildings'));
    }

    public function update(UpdateBuildingDocumentRequest $request, BuildingDocument $buildingDocument)
    {
        $buildingDocument->update($request->all());

        if ($request->input('photo', false)) {
            if (! $buildingDocument->photo || $request->input('photo') !== $buildingDocument->photo->file_name) {
                if ($buildingDocument->photo) {
                    $buildingDocument->photo->delete();
                }
                $buildingDocument->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }
        } elseif ($buildingDocument->photo) {
            $buildingDocument->photo->delete();
        }

        return redirect()->route('admin.building-documents.index');
    }

    public function show(BuildingDocument $buildingDocument)
    {
        abort_if(Gate::denies('building_document_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildingDocument->load('building');

        return view('admin.buildingDocuments.show', compact('buildingDocument'));
    }

    public function destroy(BuildingDocument $buildingDocument)
    {
        abort_if(Gate::denies('building_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildingDocument->delete();

        return back();
    }

    public function massDestroy(MassDestroyBuildingDocumentRequest $request)
    {
        $buildingDocuments = BuildingDocument::find(request('ids'));

        foreach ($buildingDocuments as $buildingDocument) {
            $buildingDocument->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('building_document_create') && Gate::denies('building_document_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new BuildingDocument();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
