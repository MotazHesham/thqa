<?php

namespace App\Http\Requests;

use App\Models\BuildingDocument;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBuildingDocumentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('building_document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:building_documents,id',
        ];
    }
}
