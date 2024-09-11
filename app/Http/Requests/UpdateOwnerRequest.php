<?php

namespace App\Http\Requests;

use App\Models\Owner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOwnerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('owner_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'last_name' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:users,email,' . request()->user_id,
            ],
            'phone' => [
                'size:10',
                'regex:/(05)[0-9]{8}/', 
                'nullable',
            ],
            'phone2' => [
                'size:10',
                'regex:/(05)[0-9]{8}/', 
                'nullable',
            ],
            'identity_num' => [
                'size:10',
                'required',
                'unique:owners,identity_num,' . request()->route('owner')->id,
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
