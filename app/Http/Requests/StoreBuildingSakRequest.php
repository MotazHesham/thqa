<?php

namespace App\Http\Requests;

use App\Models\BuildingSak;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBuildingSakRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('building_sak_create');
    }

    public function rules()
    {
        return [
            'building_id' => [
                'required',
                'integer',
            ], 
            'sak_num' => [
                'required', 
            ], 
            'date' => [
                'nullable',
                'date_format:' . config('panel.date_format'),
            ],

            'date_hijri' => [
                'nullable',
                'date_format:' . config('panel.date_format'),
            ],
            'photo' => [
                'nullable',
                'file',
                'max:8000'
            ]
        ];
    }
}
