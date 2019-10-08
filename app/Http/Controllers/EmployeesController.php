<?php

namespace App\Http\Controllers;

use App\Countrie;
use App\Employee;
use App\Jobposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use vendor\project\StatusTest;

class EmployeesController extends Controller
{

    public function index()
    {
        $this->authorize('index', Employee::class);
        $emps = Employee::select('id', 'code', 'name', 'nationality', 'hiring_date', 'address', 'social_security_no', 'jobposition_id')->get();
        return view('employees.index', compact('emps'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Employee::class);
        $countries = Countrie::select('name', 'code')->get();
        $jobpositions = Jobposition::select('id', 'code')->get();
        return view('employees.add', compact('countries', 'jobpositions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Employee::class);
        $this->validate($request,[
            'code' => 'required|unique:employees,code',
//            'code' => 'required|unique:employees,code,NULL,id,deleted_at,NULL',
            'name' => 'required',
            'cin' => "required|unique:employees,cin",
//            'cin' => "required|unique:employees,cin,NULL,id,deleted_at,NULL",
            'birth_date' => 'required|date',
            'hiring_date' => 'date',
            'nationality' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'social_security_no' => 'required',
            'email' => 'email|unique:employees,email',
//            'email' => 'email|unique:employees,email,NULL,id,deleted_at,NULL',
            'image' => 'image|max:1999']);
        $data = $request->all();
        $job = Jobposition::find($data['jobposition']);
        if ($job) {
            $employee = new Employee();
            $employee->name = $data['name'];
            $employee->cin = $data['cin'];
            $employee->phone = $data['phone'];
            $employee->code = $data['code'];
            $employee->birth_date = $data['birth_date'];
            $employee->hiring_date = $data['hiring_date'];
            $employee->nationality = $data['nationality'];
            $employee->address = $data['address'];
            $employee->jobposition_id = $data['jobposition'];
            $employee->zip_code = $data['zip_code'];
            $employee->social_security_no = $data['social_security_no'];
            $employee->email = $data['email'];
            if ($request->hasFile('image')) {
                $name_image = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('emplys/images'), $name_image);
                $employee->image = $name_image;
            }
            $employee->save();
            session()->flash('success_added', 'Employee added successfully');
            return redirect('employees/' . $employee->id);
            return redirect('employees');
        } else
            return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);
        $this->authorize('view',$employee);
//        $salaries=$employee->salaries()->paginate(1);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id);
        $this->authorize('update',$employee);
        $countries = Countrie::select('name', 'code')->get();
        $jobpositions = Jobposition::select('id', 'code')->get();
        return view('employees.edit', compact('employee', 'countries', 'jobpositions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        $this->authorize('update',$employee);
        $this->validate($request, [
            'code' => "required|unique:employees,code,$id",
//            'code' => "required|unique:employees,code,$id,id,deleted_at,NULL",
            'name' => 'required',
            'cin' => "required|unique:employees,cin,$id",
//            'cin' => "required|unique:employees,cin,$id,id,deleted_at,NULL",
            'birth_date' => 'required|date',
            'hiring_date' => 'date',
            'nationality' => 'required',
            'address' => 'required',
            'zip_code' => 'required',
            'social_security_no' => 'required',
            'email' => "email|unique:employees,email,$id",
            'image' => 'image|max:1999']);
        $data = $request->all();
        $job = Jobposition::find($data['jobposition']);
        if ($job) {

            $employee->name = $data['name'];
            $employee->code = $data['code'];
            $employee->cin = $data['cin'];
            $employee->phone = $data['phone'];
            $employee->birth_date = $data['birth_date'];
            $employee->hiring_date = $data['hiring_date'];
            $employee->nationality = $data['nationality'];
            $employee->address = $data['address'];
            $employee->zip_code = $data['zip_code'];
            $employee->jobposition_id = $data['jobposition'];
            $employee->social_security_no = $data['social_security_no'];
            $employee->email = $data['email'];
            if($employee->user!=null)
            {
                $user=$employee->user;
                $user->email=$data['email'];
                $user->save();
            }
            if ($request->hasFile('image')) {
                $name_image = time() . '.' . $request->image->getClientOriginalExtension();
                $request->image->move(public_path('emplys/images'), $name_image);
                $employee->image = $name_image;
            }
            $employee->save();
            session()->flash('success', 'Employee updated successfully');
            return redirect('employees');
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       $employee=Employee::find($id);
        $this->authorize('delete',$employee);
       $user=$employee->user;
       if($user!=null)
       $user->delete();
       $employee->delete();
       session()->flash('success','Employee deleted successfully');
       return back();
    }

    public function deleted()
    {
        $this->authorize('index',Employee::class);
        $employees=Employee::onlyTrashed()->get();
        return view('employees.trashed',compact('employees'));
    }
    public function restore($id)
    {
        $employee=Employee::onlyTrashed()->find($id);
        $employee->restore();
        session()->flash('success','Employee restored successfully');
        return back();
    }

    public function __construct()
    {
        $this->middleware('auth');
    }


}
