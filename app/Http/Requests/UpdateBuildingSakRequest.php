<?php

namespace App\Http\Requests;

use App\Models\BuildingSak;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateBuildingSakRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('building_sak_edit');
    }

    public function rules()
    {
        return [
            'building_id' => [
                'required',
                'integer',
            ],
            'sak_num' => [
                'string',
                'required',
            ],
            'photo' => [
                'required',
            ],
        ];
    }
}
