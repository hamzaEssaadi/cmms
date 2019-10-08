<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Mail\Credentials;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('index',User::class);
        $users=User::all()->where('role','<>','super_admin');
        return view('users.index',compact('users'));
    }

    public function create()
    {
        $this->authorize('create',User::class);
        $employees=Employee::ListEmployeeToAdd();
        return view('users.create',compact('employees'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete',$user);
        $user->delete();
        session()->flash('success','User deleted successfully');
        return back();
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    public function store(Request $request)
    {
        $this->authorize('create',User::class);
        $this->validate($request ,[
            'employee'=>'required',
            'role'=>'required',
            'password'=>'required'
        ]);
        $data=$request->all();
        $employee=Employee::find($data['employee']);
        if($employee==null)
            return back();
        if( !($data['role']=='rh_manager' || $data['role']=='stock_manager' ||
            $data['role']=='maintenance_manager' || $data['role']=='average_user' || $data['role']='project_manager'))
        return back();
        else
        {
            if($data['role']=='rh_manager' && Auth::user()->role!='super_admin')
                return back();
        }
        $user=new User();
        $user->name=$employee->name;
        $user->email=$employee->email;
        $user->employee_id=$employee->id;
        $user->role=$data['role'];
        $user->password=Hash::make($data['password']);
        $user->save();
        try {
            Mail::to($employee->email)
                ->send(new Credentials($employee->email, $data['password'], $employee->name));
        }
        catch (\Exception $exception)
        {

        }
        session()->flash('success','Account added successfully');
        return back();
    }

    public function update(Request $request,User $user)
    {
        $this->authorize('update',$user);
        $this->validate($request ,[
            'role'=>'required',
            'password'=>'nullable|min:3'
        ]);
        $data=$request->all();
        if( !($data['role']=='rh_manager' || $data['role']=='stock_manager' ||
            $data['role']=='maintenance_manager' || $data['role']=='average_user' || $data['role']='project_manager'))
            return back();
        else{
            if($data['role']=='rh_manager' && Auth::user()->role!='super_admin')
                return back();
        }
        $user->role=$data['role'];
        if(trim($request->password)!='')
        {
            $user->password=Hash::make($data['password']);
            try {
                Mail::to($user->email)
                    ->send(new Credentials($user->email, $data['password'], $user->employee->name));
            }
            catch (\Exception $exception){}
        }
        $user->save();
        session()->flash('success','Account updated successfully');
        return redirect(route('users.index'));
    }

    public function profileEdit(User $user)
    {
        $this->authorize('profile',$user);
        return view('users.profile',compact('user'));
    }

    public function updateProfile(Request $request,User $user)
    {
        $this->authorize('profile',$user);
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|unique:users,email,'.$user->id,
            'password'=>'nullable|min:3|confirmed',
//            'password_confirmation'=>'nullable'
        ]);
        $data=$request->all();
        if(trim($request->password)!='')
            $user->password=Hash::make($data['password']);
        $user->name=$data['name'];
        $user->email=$data['email'];
        $user->save();
        try {
            Mail::to($user->email)
                ->send(new Credentials($user->email, $data['password'], $user->name));
        }
        catch (\Exception $exception)
        {
//            return $exception->getMessage();
        }
        session()->flash('success','Your profile has been updated successfully');
        return back();
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
