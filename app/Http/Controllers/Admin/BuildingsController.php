<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBuildingRequest;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Models\Building;
use App\Models\BuildingDocument;
use App\Models\BuildingSak;
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

    public function index(Request $request)
    {
        abort_if(Gate::denies('building_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildings = Building::with(['owner.user', 'employee', 'country', 'city', 'media']);

        if($request->has('search')){
            global $search;
            $search = $request->search; 
            $buildings->whereHas('owner.user',function($q){
                $q->where('name', 'like', '%'.$GLOBALS['search'].'%')
                ->orWhere('last_name', 'like', '%'.$GLOBALS['search'].'%');
            })->orWhereHas('employee',function($q){
                $q->where('name', 'like', '%'.$GLOBALS['search'].'%')
                ->orWhere('last_name', 'like', '%'.$GLOBALS['search'].'%');
            })
            ->orWhereRelation('country','name','like', '%'.$GLOBALS['search'].'%')
            ->orWhereRelation('city','name','like', '%'.$GLOBALS['search'].'%')
            ->orWhere('id', 'like', '%'.$GLOBALS['search'].'%')
            ->orWhere('name', 'like', '%'.$GLOBALS['search'].'%')
            ->orWhere('address', 'like', '%'.$GLOBALS['search'].'%');
        }

        $buildings = $buildings->orderBy('created_at','desc')->paginate(10);
        return view('admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        abort_if(Gate::denies('building_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = Owner::with('user')->get();
        
        $employees = User::select('name','last_name', 'id')->where('user_type','staff')->get();

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

        foreach($request->saks as $sak){
            $buildingSak = BuildingSak::create([
                'building_id' => $building->id,
                'sak_num' => $sak['num'],
            ]);
            if (array_key_exists("photo",$sak) && $sak['photo'] != null) {
                $buildingSak->addMedia($sak['photo'])->toMediaCollection('photo');
            }
        } 
        foreach($request->documents as $document){
            $buildingDocument = BuildingDocument::create([
                'building_id' => $building->id,
                'file_num' => $document['num'],
                'file_name' => $document['name'],
                'file_type' => $document['type'],
                'file_date' => $document['date'],
            ]);
            if (array_key_exists("photo",$document) && $document['photo'] != null) {
                $buildingDocument->addMedia($document['photo'])->toMediaCollection('photo');
            }
        }
        return redirect()->route('admin.buildings.index');
    }

    public function edit(Building $building)
    {
        abort_if(Gate::denies('building_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = Owner::with('user')->get();
        
        $employees = User::select('name','last_name', 'id')->where('user_type','staff')->get();

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


        foreach($request->saks as $sak){
            if($sak['num']){
                $buildingSak = BuildingSak::create([
                    'building_id' => $building->id,
                    'sak_num' => $sak['num'],
                ]);
                if (array_key_exists("photo",$sak) && $sak['photo'] != null) {
                    $buildingSak->addMedia($sak['photo'])->toMediaCollection('photo');
                }
            }
        } 
        foreach($request->documents as $document){
            if($document['num'] || $document['name'] || $document['type'] || $document['date']){
                $buildingDocument = BuildingDocument::create([
                    'building_id' => $building->id,
                    'file_num' => $document['num'],
                    'file_name' => $document['name'],
                    'file_type' => $document['type'],
                    'file_date' => $document['date'],
                ]);
                if (array_key_exists("photo",$document) && $document['photo'] != null) {
                    $buildingDocument->addMedia($document['photo'])->toMediaCollection('photo');
                }
            }
        }

        return redirect()->route('admin.buildings.index');
    }

    public function show(Building $building)
    {
        abort_if(Gate::denies('building_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $building->load('employee', 'country', 'city', 'buildingBuildingDocuments' , 'buildingBuildingSaks');
        
        $owner = Owner::find($building->owner_id);
        $owner->load('ownerBuildings','user');

        return view('admin.buildings.show', compact('building','owner'));
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
