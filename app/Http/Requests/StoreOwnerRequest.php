<?php

namespace App\Http\Requests;

use App\Models\Owner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOwnerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('owner_create');
    }

    public function rules()
    {
        return [
            'identity_num' => [
                'string',
                'nullable',
            ],
            'identity_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'address' => [
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
        ];
    }
}
