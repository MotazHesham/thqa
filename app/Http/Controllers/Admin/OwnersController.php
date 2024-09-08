<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOwnerRequest;
use App\Http\Requests\StoreOwnerRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\Owner;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnersController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('owner_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owners = Owner::with(['user']);

        if($request->has('search')){
            global $search;
            $search = $request->search; 
            $owners->whereHas('user',function($q){
                $q->where('name', 'like', '%'.$GLOBALS['search'].'%')
                ->orWhere('last_name', 'like', '%'.$GLOBALS['search'].'%')
                ->orWhere('email', 'like', '%'.$GLOBALS['search'].'%')
                ->orWhere('phone', 'like', '%'.$GLOBALS['search'].'%');
            })
            ->orWhere('id', 'like', '%'.$GLOBALS['search'].'%')
            ->orWhere('identity_num', 'like', '%'.$GLOBALS['search'].'%')
            ->orWhere('address', 'like', '%'.$GLOBALS['search'].'%');
        }

        $owners = $owners->orderBy('created_at','desc')->paginate(10);

        return view('admin.owners.index', compact('owners'));
    }

    public function create()
    {
        abort_if(Gate::denies('owner_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.owners.create', compact('users'));
    }

    public function store(StoreOwnerRequest $request)
    { 
        $user = User::create([
            'user_type' => 'owner',
            'name' => $request->name ,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt('password'),
            'phone' => $request->phone,
            'phone2' => $request->phone2,
            'mobile' => $request->mobile,
            'mobile2' => $request->mobile2,
            'approved' => 1, 
        ]);

        $owner = Owner::create([ 
            'user_id' => $user->id,
            'gender' => $request->gender,
            'identity_num' => $request->identity_num,
            'identity_date' => $request->identity_date,
            'address' => $request->address,
            'commerical_num' => $request->commerical_num,
            'real_estate_identity' => $request->real_estate_identity,
        ]);
        
        if ($request->photo != null) {
            $user->addMedia($request->photo)->toMediaCollection('photo');
        }

        return redirect()->route('admin.owners.index');
    }

    public function edit(Owner $owner)
    {
        abort_if(Gate::denies('owner_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owner->load('user','ownerBuildings');

        $user = $owner->user;

        return view('admin.owners.edit', compact('owner', 'user'));
    }

    public function update(UpdateOwnerRequest $request, Owner $owner)
    {
        $user = User::findOrFail($owner->user_id);

        $user->update([  
            'name' => $request->name ,
            'last_name' => $request->last_name,
            'email' => $request->email, 
            'phone' => $request->phone,
            'phone2' => $request->phone2,
            'mobile' => $request->mobile,
            'mobile2' => $request->mobile2,
        ]);

        $owner->update([  
            'gender' => $request->gender,
            'identity_num' => $request->identity_num,
            'identity_date' => $request->identity_date,
            'address' => $request->address,
            'commerical_num' => $request->commerical_num,
            'real_estate_identity' => $request->real_estate_identity,
        ]);
        
        if ($request->photo != null) {
            $user->addMedia($request->photo)->toMediaCollection('photo');
        }

        return redirect()->route('admin.owners.index');
    }

    public function show(Owner $owner)
    {
        abort_if(Gate::denies('owner_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owner->load('user', 'ownerBuildings');

        return view('admin.owners.show', compact('owner'));
    }

    public function destroy(Owner $owner)
    {
        abort_if(Gate::denies('owner_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $owner->delete();

        return back();
    }

    public function massDestroy(MassDestroyOwnerRequest $request)
    { 
        $owners = Owner::find(request('ids'));

        foreach ($owners as $owner) {
            $owner->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
