<?php

namespace App\Http\Controllers;

use App\Jobposition;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index',Jobposition::class);
        $jobs=Jobposition::all();
        return view('jobPosition.index',compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create',Jobposition::class);
        return view('jobPosition.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Jobposition::class);
        $this->validate($request,['code'=>'required|unique:jobpositions,code',
                                  'description'=>'required']);
        $data=$request->all();
        $job=new Jobposition();
        $job->code=$data['code'];
        $job->description=$data['description'];
        $job->save();
        session()->flash('success','Job position added successfully');
        return redirect('jobpositions/create');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $job=Jobposition::find($id);
        $this->authorize('update',$job);
        return view('jobPosition.edit',compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $jobposition=Jobposition::find($id);
        $this->authorize('update',$jobposition);
        $this->validate($request,['code'=>"required|unique:jobpositions,code,$id",
            'description'=>'required']);
        $jobposition->code=$request->code;
        $jobposition->description=$request->description;
        $jobposition->save();
        session()->flash('success','Job position updated successfully');
        return redirect('jobpositions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
