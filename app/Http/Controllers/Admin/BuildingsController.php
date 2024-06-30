<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBuildingRequest;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Models\Building;
use App\Models\City;
use App\Models\Country;
use App\Models\Owner;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class BuildingsController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('building_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildings = Building::with(['owner', 'employee', 'country', 'city', 'media'])->get();

        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        abort_if(Gate::denies('building_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = Owner::pluck('identity_num', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.buildings.create', compact('cities', 'countries', 'employees', 'owners'));
    }

    public function store(StoreBuildingRequest $request)
    {
        $building = Building::create($request->all());

        foreach ($request->input('photos', []) as $file) {
            $building->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $building->id]);
        }

        return redirect()->route('admin.buildings.index');
    }

    public function edit(Building $building)
    {
        abort_if(Gate::denies('building_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = Owner::pluck('identity_num', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $building->load('owner', 'employee', 'country', 'city');

        return view('admin.buildings.edit', compact('building', 'cities', 'countries', 'employees', 'owners'));
    }

    public function update(UpdateBuildingRequest $request, Building $building)
    {
        $building->update($request->all());

        if (count($building->photos) > 0) {
            foreach ($building->photos as $media) {
                if (! in_array($media->file_name, $request->input('photos', []))) {
                    $media->delete();
                }
            }
        }
        $media = $building->photos->pluck('file_name')->toArray();
        foreach ($request->input('photos', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $building->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
            }
        }

        return redirect()->route('admin.buildings.index');
    }

    public function show(Building $building)
    {
        abort_if(Gate::denies('building_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $building->load('owner', 'employee', 'country', 'city', 'buildingBuildingDocuments');

        return view('admin.buildings.show', compact('building'));
    }

    public function destroy(Building $building)
    {
        abort_if(Gate::denies('building_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $building->delete();

        return back();
    }

    public function massDestroy(MassDestroyBuildingRequest $request)
    {
        $buildings = Building::find(request('ids'));

        foreach ($buildings as $building) {
            $building->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('building_create') && Gate::denies('building_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Building();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
