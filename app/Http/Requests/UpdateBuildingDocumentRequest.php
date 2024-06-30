<?php

namespace App\Http\Requests;

use App\Models\BuildingDocument;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBuildingDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('building_document_edit');
    }

    public function rules()
    {
        return [
            'file_num' => [
                'string',
                'nullable',
            ],
            'file_name' => [
                'string',
                'nullable',
            ],
            'file_type' => [
                'string',
                'nullable',
            ],
            'file_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
