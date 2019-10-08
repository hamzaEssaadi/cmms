<?php

namespace App\Http\Controllers;

use App\Equipment;
use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function create(Equipment $equipment)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        return view('equipments.payments.create',compact('equipment'));
    }

    public function store(Request $request,Equipment $equipment)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $this->validate($request,[
            'date'=>'date',
            'amount'=>'required|numeric',
        ]);
        $data=$request->all();
        $payment=new Payment();
        $payment->method=$data['method'];
        $payment->date=$data['date'];
        $payment->amount=$data['amount'];
        $payment->equipment_id=$equipment->id;
        $payment->save();
        session()->flash('success','Payment added successfully');
        session()->flash('tab','payments');
        return back();
    }

    public function destroy(Payment $payment)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $payment->delete();
        session()->flash('success_payment','Payment deleted successfully');
        session()->flash('tab','payments');
        return back();
    }
}
