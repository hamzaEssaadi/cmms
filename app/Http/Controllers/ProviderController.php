<?php

namespace App\Http\Controllers;

use App\Countrie;
use App\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index($type)
    {
        $this->authorize('index',Provider::class);
        $providers = Provider::select('id','code', 'name', 'phone', 'fax', 'email', 'web_site', 'director')->where('type', $type)->get();
        return view('providers.index', compact('providers', 'type'));
    }

    public function create($type)
    {
        $this->authorize('create',Provider::class);
        $countries = Countrie::select('name', 'code')->get();
        return view('providers.create', compact('type', 'countries'));
    }

    public function store(Request $request,$type)
    {
        $this->authorize('create',Provider::class);
        $this->validate($request,['code'=>'required|unique:providers,code',
            'name'=>'required',
            'country'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
            'email'=>'email',
            'city'=>'required',
            'phone'=>'required',
            'director'=>'required'
           ]);
        $data=$request->all();
        $provider=new Provider();
        $provider->code=$data['code'];
        $provider->name=$data['name'];
        $provider->country=$data['country'];
        $provider->zip_code=$data['zip_code'];
        $provider->phone=$data['phone'];
        $provider->city=$data['city'];
        $provider->address=$data['address'];
        $provider->email=$data['email'];
        $provider->web_site=$data['web_site'];
        $provider->director=$data['director'];
        $provider->fax=$data['fax'];
        $provider->type=$type;
        $provider->save();
        session()->flash('success',ucwords($type).' added successfully');
        return redirect('providers/'.$type.'/create');
    }

    public function edit(Provider $provider)
    {
        $this->authorize('update',$provider);
        $countries = Countrie::select('name', 'code')->get();
        return view('providers.edit',compact('provider','countries'));
    }

    public function update(Request $request,Provider $provider)
    {
        $this->authorize('update',$provider);
        $id=$provider->id;
        $this->validate($request,['code'=>"required|unique:providers,code,$id",
            'name'=>'required',
            'country'=>'required',
            'address'=>'required',
            'zip_code'=>'required',
            'email'=>'email',
            'city'=>'required',
            'phone'=>'required',
            'director'=>'required'
        ]);
        $data=$request->all();
        $provider->code=$data['code'];
        $provider->name=$data['name'];
        $provider->country=$data['country'];
        $provider->zip_code=$data['zip_code'];
        $provider->phone=$data['phone'];
        $provider->city=$data['city'];
        $provider->address=$data['address'];
        $provider->email=$data['email'];
        $provider->web_site=$data['web_site'];
        $provider->director=$data['director'];
        $provider->fax=$data['fax'];
        $provider->save();
        session()->flash('success',ucwords($provider->type).' updated successfully');
        return redirect('providers/'.$provider->type);
    }
    public function __construct()
    {
        $this->middleware('auth');
    }
}
