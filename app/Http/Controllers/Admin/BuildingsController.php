<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyBuildingRequest;
use App\Http\Requests\StoreBuildingRequest;
use App\Http\Requests\UpdateBuildingRequest;
use App\Models\Building;
use App\Models\BuildingDocument;
use App\Models\BuildingFolder;
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

    public function show_folder_files(Request $request){
        if($request->type == 'sak'){
            if($request->folder_id){
                $folder = BuildingFolder::find($request->folder_id);
                $saks = BuildingSak::where('building_folder_id',$request->folder_id)->get();
                return view('admin.buildings.partials.saks',compact('saks','folder'));
            }else{ 
                $folder = null;
                $folders = BuildingFolder::where('type','sak')->where('building_id',$request->building_id)->get();
                $saks = BuildingSak::where('building_id',$request->building_id)->get();
                
                return view('admin.buildings.partials.saks',compact('saks','folder','folders'));
            }
        }elseif($request->type == 'document'){
            if($request->folder_id){
                $folder = BuildingFolder::find($request->folder_id);
                $documents = BuildingDocument::where('building_folder_id',$request->folder_id)->get();
                return view('admin.buildings.partials.documents',compact('documents','folder'));
            }else{
                $folder = null;
                $folders = BuildingFolder::where('type','document')->where('building_id',$request->building_id)->get();
                $documents = BuildingDocument::where('building_id',$request->building_id)->get();
                
                return view('admin.buildings.partials.documents',compact('documents','folder','folders'));
            }
        }else{
            abort(403);
        }
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('building_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $buildings = Building::with(['owner.user', 'employees', 'country', 'city', 'media']);

        if($request->has('search')){
            global $search;
            $search = $request->search; 
            $buildings->whereHas('owner.user',function($q){
                $q->where('name', 'like', '%'.$GLOBALS['search'].'%')
                ->orWhere('last_name', 'like', '%'.$GLOBALS['search'].'%');
            })->orWhereHas('employees',function($q){
                $q->where('name', 'like', '%'.$GLOBALS['search'].'%')
                ->orWhere('last_name', 'like', '%'.$GLOBALS['search'].'%');
            })
            ->orWhereRelation('country','name','like', '%'.$GLOBALS['search'].'%')
            ->orWhereRelation('city','name','like', '%'.$GLOBALS['search'].'%')
            ->orWhere('code', 'like', '%'.$GLOBALS['search'].'%')
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
        $owner = Owner::findOrFail($request->owner_id);
        $buildingCount = count($owner->ownerBuildings);
        $validatedRequest = $request->all();
        $validatedRequest['code'] = 'Th-' . $request->owner_id . '-' . Building::BUILDING_TYPE_REF_SELECT[$request->building_type] . '-' . ($buildingCount + 1);
        $building = Building::create($validatedRequest);
        
        foreach ($request->input('photos', []) as $file) {
            $building->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photos');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $building->id]);
        }

        if ($request->has('employees')) {
            if (in_array('all', $request->employees)) {
                $employees = User::where('user_type','staff')->pluck('id');
            } else {
                $employees = $request->employees;
            }
            $building->employees()->sync($employees);
        }

        if($request->has('save_upload')){
            $redirect_link = route('admin.buildings.show',$building->id);
            return redirect()->to($redirect_link . '?sak_more=1');
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

        $building->load('owner', 'employees', 'country', 'city');

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

        if ($request->has('employees')) {
            if (in_array('all', $request->employees)) {
                $employees = User::where('user_type','staff')->pluck('id');
            } else {
                $employees = $request->employees;
            }
            $building->employees()->sync($employees);
        } else {
            $building->employees()->sync([]);
        } 

        return redirect()->route('admin.buildings.index');
    }

    public function show(Building $building)
    {
        
        abort_if(Gate::denies('building_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $building->load('employees', 'country', 'city','folders');

        $buildingBuildingDocuments = BuildingDocument::where('building_id',$building->id);
        $buildingBuildingSaks = BuildingSak::where('building_id',$building->id);

        if(request()->has('search_files') && request()->search_files != null){
            $buildingBuildingDocuments = $buildingBuildingDocuments->where('file_name', 'like', '%' . request()->search_files . '%')
                                                                    ->orWhere('file_num', 'like', '%' . request()->search_files . '%')
                                                                    ->orWhere('file_type', 'like', '%' . request()->search_files . '%');
        }

        if(request()->has('search_sak') && request()->search_sak != null){
            $buildingBuildingSaks = $buildingBuildingSaks->where('sak_num', 'like', '%' . request()->search_sak . '%');
        }

        $buildingBuildingDocuments = $buildingBuildingDocuments->get();    
        $buildingBuildingSaks = $buildingBuildingSaks->get();
        $owner = Owner::find($building->owner_id);
        $owner->load('ownerBuildings','user');

        $folders = BuildingFolder::where('type','sak')->where('building_id',$building->id)->get();
        $folders2 = BuildingFolder::where('type','document')->where('building_id',$building->id)->get();

        return view('admin.buildings.show', compact('building','owner','buildingBuildingDocuments','buildingBuildingSaks','folders','folders2'));
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
