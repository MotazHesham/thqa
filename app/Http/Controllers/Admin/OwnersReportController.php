<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOwnersReportRequest;
use App\Http\Requests\StoreOwnersReportRequest;
use App\Http\Requests\UpdateOwnersReportRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnersReportController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('owners_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ownersReports.index');
    }

    public function create()
    {
        abort_if(Gate::denies('owners_report_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ownersReports.create');
    }

    public function store(StoreOwnersReportRequest $request)
    {
        $ownersReport = OwnersReport::create($request->all());

        return redirect()->route('admin.owners-reports.index');
    }

    public function edit(OwnersReport $ownersReport)
    {
        abort_if(Gate::denies('owners_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ownersReports.edit', compact('ownersReport'));
    }

    public function update(UpdateOwnersReportRequest $request, OwnersReport $ownersReport)
    {
        $ownersReport->update($request->all());

        return redirect()->route('admin.owners-reports.index');
    }

    public function show(OwnersReport $ownersReport)
    {
        abort_if(Gate::denies('owners_report_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.ownersReports.show', compact('ownersReport'));
    }

    public function destroy(OwnersReport $ownersReport)
    {
        abort_if(Gate::denies('owners_report_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ownersReport->delete();

        return back();
    }

    public function massDestroy(MassDestroyOwnersReportRequest $request)
    {
        $ownersReports = OwnersReport::find(request('ids'));

        foreach ($ownersReports as $ownersReport) {
            $ownersReport->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
