<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuildingDocument;
use App\Models\BuildingFolder;
use App\Models\BuildingSak;
use Illuminate\Http\Request;

class BuildingFoldersController extends Controller
{
    public function store(Request $request){
        BuildingFolder::create($request->all());
        
        return  redirect()->back();
    }
    public function update(Request $request,BuildingFolder $buildingFolder){
        $buildingFolder->update($request->all());
        
        return  redirect()->back();
    }

    public function delete_folder($folder_id){
        if(!BuildingSak::where('building_folder_id',$folder_id)->first() && !BuildingDocument::where('building_folder_id',$folder_id)->first()){
            BuildingFolder::destroy($folder_id);
        }
        return  redirect()->back();
    }

    public function update_folder(Request $request){
        if($request->type == 'sak'){

            $sak = BuildingSak::findOrFail($request->sak_id);
            $sak->building_folder_id = $request->building_folder_id;
            $sak->save();
        }elseif($request->type == 'document'){
            
            $sak = BuildingDocument::findOrFail($request->document_id);
            $sak->building_folder_id = $request->building_folder_id;
            $sak->save();
        }else{
            return 0;
        }
        return 1;
    }
}
