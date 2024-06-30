<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyReportBuildingRequest;
use App\Http\Requests\StoreReportBuildingRequest;
use App\Http\Requests\UpdateReportBuildingRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportBuildingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('report_building_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reportBuildings.index');
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
