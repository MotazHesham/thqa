<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Owner;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(){
        $buildings = Building::with('owner.user')->get();
        $owners = Owner::with('user')->get();
        return view('admin.map.map',compact('buildings','owners'));
    }
}
