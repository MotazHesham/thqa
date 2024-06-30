<?php

namespace App\Http\Requests;

use App\Models\BuildingSak;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBuildingSakRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('building_sak_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:building_saks,id',
        ];
    }
}
