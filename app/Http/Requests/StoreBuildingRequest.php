<?php

namespace App\Http\Requests;

use App\Models\Building;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBuildingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('building_create');
    }

    public function rules()
    {
        return [
            'owner_id' => [
                'required',
                'integer',
            ],
            'name' => [
                'string',
                'required',
            ],
            'map_lat' => [
                'string',
                'required',
            ],
            'map_long' => [
                'string',
                'required',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'building_type' => [
                'required',
            ],
            'building_status' => [
                'required',
            ],
            'owned_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'registration_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'survey_descision' => [
                'string',
                'nullable',
            ],
            'commerical_num' => [
                'string',
                'nullable',
            ],
            'real_estate_identity' => [
                'string',
                'nullable',
            ],
            'photos' => [
                'array',
            ],
        ];
    }
}
