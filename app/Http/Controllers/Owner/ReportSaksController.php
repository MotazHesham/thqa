<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyReportSakRequest;
use App\Http\Requests\StoreReportSakRequest;
use App\Http\Requests\UpdateReportSakRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportSaksController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('report_sak_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reportSaks.index');
    }

    public function create()
    {
        abort_if(Gate::denies('report_sak_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reportSaks.create');
    }

    public function store(StoreReportSakRequest $request)
    {
        $reportSak = ReportSak::create($request->all());

        return redirect()->route('admin.report-saks.index');
    }

    public function edit(ReportSak $reportSak)
    {
        abort_if(Gate::denies('report_sak_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reportSaks.edit', compact('reportSak'));
    }

    public function update(UpdateReportSakRequest $request, ReportSak $reportSak)
    {
        $reportSak->update($request->all());

        return redirect()->route('admin.report-saks.index');
    }

    public function show(ReportSak $reportSak)
    {
        abort_if(Gate::denies('report_sak_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reportSaks.show', compact('reportSak'));
    }

    public function destroy(ReportSak $reportSak)
    {
        abort_if(Gate::denies('report_sak_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reportSak->delete();

        return back();
    }

    public function massDestroy(MassDestroyReportSakRequest $request)
    {
        $reportSaks = ReportSak::find(request('ids'));

        foreach ($reportSaks as $reportSak) {
            $reportSak->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
