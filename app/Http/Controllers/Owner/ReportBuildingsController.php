<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyReportBuildingRequest;
use App\Http\Requests\StoreReportBuildingRequest;
use App\Http\Requests\UpdateReportBuildingRequest;
use App\Models\Building;
use App\Models\City;
use App\Models\Country;
use App\Models\Owner;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportBuildingsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('report_building_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');


        $owners = Owner::with('user')->get();
        
        $countries = Country::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $cities = City::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $employees = User::select('name','last_name', 'id')->where('user_type','staff')->get();

        $search = false;

        $buildings = null;
        $country_id = null;
        $city_id = null;
        $employee_id = null;
        $owner_id = null;
        $phone = null;
        $identity_num = null;
        $date_type = null;
        $from_date = null;
        $to_date = null;
        $address = null;
        $name = null;
        $building_status = null;
        $building_type = null;

        if($request->has('search')){
            $search = true;
            
            $buildings = Building::with(['owner.user', 'employee', 'country', 'city', 'media']);

            if($request->country_id != null){ 
                $country_id = $request->country_id; 
                $buildings->where('country_id',$country_id);
            }
            if($request->city_id != null){ 
                $city_id = $request->city_id; 
                $buildings->where('city_id',$city_id);
            }
            if($request->owner_id != null){ 
                $owner_id = $request->owner_id; 
                $buildings->where('owner_id',$owner_id);
            }

            if($request->employee_id != null){
                $employee_id = $request->employee_id; 
                $buildings->where('employee_id',$employee_id);
            }
            if($request->building_status != null){
                $building_status = $request->building_status; 
                $buildings->where('building_status',$building_status);
            }
            if($request->building_type != null){
                $building_type = $request->building_type; 
                $buildings->where('building_type',$building_type);
            }
            if($request->name != null){
                $name = $request->name; 
                $buildings->where('name', 'like', '%'.$name.'%');
            }
            if($request->address != null){
                $address = $request->address; 
                $buildings->where('address', 'like', '%'.$address.'%');
            }
            
            if($request->identity_num != null){
                global $identity_num;
                $identity_num = $request->identity_num; 
                $buildings->whereHas('owner',function($q){
                    $q->where('identity_num', 'like', '%'.$GLOBALS['identity_num'].'%');
                });
            }
            
            if($request->phone != null){
                global $phone;
                $phone = $request->phone; 
                $buildings->whereHas('owner.user',function($q){
                    $q->where('phone', 'like', '%'.$GLOBALS['phone'].'%');
                });
            } 

            if ($request->from_date != null && $request->to_date != null && $request->date_type != null) {  
                $from_date = \Carbon\Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $request->from_date . ' ' . '12:00 am')->format('Y-m-d H:i:s');
                $to_date = \Carbon\Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $request->to_date . ' ' . '11:59 pm')->format('Y-m-d H:i:s'); 
                $date_type = $request->date_type;
                $receipts = $buildings->whereBetween($date_type, [$from_date, $to_date]);
            }

            $buildings = $buildings->orderBy('created_at','desc')->paginate(20);
        }
        
        return view('admin.reportBuildings.index',compact('countries','cities','owners','buildings','search','country_id','from_date',
                                                            'city_id','employee_id','owner_id','phone','identity_num','date_type',
                                                            'to_date','address','name','building_status','building_type','employees')); 
    }

    public function create()
    {
        abort_if(Gate::denies('report_building_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reportBuildings.create');
    }

    public function store(StoreReportBuildingRequest $request)
    {
        $reportBuilding = ReportBuilding::create($request->all());

        return redirect()->route('admin.report-buildings.index');
    }

    public function edit(ReportBuilding $reportBuilding)
    {
        abort_if(Gate::denies('report_building_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reportBuildings.edit', compact('reportBuilding'));
    }

    public function update(UpdateReportBuildingRequest $request, ReportBuilding $reportBuilding)
    {
        $reportBuilding->update($request->all());

        return redirect()->route('admin.report-buildings.index');
    }

    public function show(ReportBuilding $reportBuilding)
    {
        abort_if(Gate::denies('report_building_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reportBuildings.show', compact('reportBuilding'));
    }

    public function destroy(ReportBuilding $reportBuilding)
    {
        abort_if(Gate::denies('report_building_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportBuilding->delete();

        return back();
    }

    public function massDestroy(MassDestroyReportBuildingRequest $request)
    {
        $reportBuildings = ReportBuilding::find(request('ids'));

        foreach ($reportBuildings as $reportBuilding) {
            $reportBuilding->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
