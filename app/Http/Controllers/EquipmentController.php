<?php

namespace App\Http\Controllers;

use App\Article;
use App\Department;
use App\Employee;
use App\Equipment;
use App\Equipment_type;
use App\Location;
use App\Provider;
use App\Spare;
use App\Stock;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $equipments = Equipment::all();
        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $locations = Location::select('id', 'code')->get();
        $departments = Department::select('id', 'code')->get();
        $types = Equipment_type::select('id', 'code')->get();
        $suppliers = Provider::select('id', 'code')->where('type', 'supplier')->get();
        $manufacturers = Provider::select('id', 'code')->where('type', 'manufacturer')->get();
        $employees = Employee::select('id', 'name', 'jobposition_id')->get();
        return view('equipments.create', compact('locations', 'departments', 'types', 'suppliers', 'manufacturers',
            'employees'));
    }

    public function store(Request $request)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $this->validate($request, [
            'code' => 'required|unique:equipments,code',
            'serial_number' => 'required',
            'model_number' => 'required',
            'purchase_date' => 'required|date',
            'warranty_expiration_date' => 'required|date',
            'starting_date' => 'required|date',
            'life_time' => 'numeric',
            'security_note' => 'required',
            'location' => 'required',
            'department' => 'required',
            'type' => 'required',
            'supplier' => 'required',
            'manufacturer' => 'required',
            'employee' => 'required',
            'cost' => 'required|numeric',
        ]);
        $data = $request->all();
        $location = Location::find($data['location']);
        if ($location == null)
            return back();
        $department = Department::find($data['department']);
        if ($department == null)
            return back();
        $type = Equipment_type::find($data['type']);
        if ($type == null)
            return back();
        $supplier = Provider::find($data['supplier']);
        if ($supplier == null)
            return back();
        $manufacturer = Provider::find($data['manufacturer']);
        if ($manufacturer == null)
            return back();
        $employee = Employee::find($data['employee']);
        if ($employee == null)
            return back();
        $equipment = new Equipment();
        $equipment->code = $data['code'];
        $equipment->serial_number = $data['serial_number'];
        $equipment->model_number = $data['model_number'];
        $equipment->purchase_date = $data['purchase_date'];
        $equipment->warranty_expiration_date = $data['warranty_expiration_date'];
        $equipment->starting_date = $data['starting_date'];
        $equipment->life_time = $data['life_time'];
        $equipment->security_note = $data['security_note'];
        $equipment->location_id = $data['location'];
        $equipment->department_id = $data['department'];
        $equipment->equipment_type_id = $data['type'];
        $equipment->supplier_id = $data['supplier'];
        $equipment->manufacturer_id = $data['manufacturer'];
        $equipment->employee_id = $data['employee'];
        $equipment->cost = $data['cost'];
        $equipment->contract=$data['contract'];
        $in_service = $request->has('in_service');
        $equipment->in_service = $in_service;
        $equipment->save();
        session()->flash('success', 'Equipment added successfully');
        return back();
    }

    public function edit(Equipment $equipment)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $locations = Location::select('id', 'code')->get();
        $departments = Department::select('id', 'code')->get();
        $types = Equipment_type::select('id', 'code')->get();
        $suppliers = Provider::select('id', 'code')->where('type', 'supplier')->get();
        $manufacturers = Provider::select('id', 'code')->where('type', 'manufacturer')->get();
        $employees = Employee::select('id', 'name', 'jobposition_id')->get();
        return view('equipments.edit', compact('locations', 'departments', 'types', 'suppliers', 'manufacturers',
            'employees', 'equipment'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $id=$equipment->id;
        $this->validate($request, [
            'code' => "required|unique:equipments,code,$id",
            'serial_number' => 'required',
            'model_number' => 'required',
            'purchase_date' => 'required|date',
            'warranty_expiration_date' => 'required|date',
            'starting_date' => 'required|date',
            'life_time' => 'numeric',
            'security_note' => 'required',
            'location' => 'required',
            'department' => 'required',
            'type' => 'required',
            'supplier' => 'required',
            'manufacturer' => 'required',
            'employee' => 'required',
            'cost' => 'required|numeric',
        ]);
        $data = $request->all();
        $location = Location::find($data['location']);
        if ($location == null)
            return back();
        $department = Department::find($data['department']);
        if ($department == null)
            return back();
        $type = Equipment_type::find($data['type']);
        if ($type == null)
            return back();
        $supplier = Provider::find($data['supplier']);
        if ($supplier == null)
            return back();
        $manufacturer = Provider::find($data['manufacturer']);
        if ($manufacturer == null)
            return back();
        $employee = Employee::find($data['employee']);
        if ($employee == null)
            return back();
        $equipment->code = $data['code'];
        $equipment->serial_number = $data['serial_number'];
        $equipment->model_number = $data['model_number'];
        $equipment->purchase_date = $data['purchase_date'];
        $equipment->warranty_expiration_date = $data['warranty_expiration_date'];
        $equipment->starting_date = $data['starting_date'];
        $equipment->life_time = $data['life_time'];
        $equipment->security_note = $data['security_note'];
        $equipment->location_id = $data['location'];
        $equipment->department_id = $data['department'];
        $equipment->equipment_type_id = $data['type'];
        $equipment->supplier_id = $data['supplier'];
        $equipment->manufacturer_id = $data['manufacturer'];
        $equipment->employee_id = $data['employee'];
        $equipment->cost = $data['cost'];
        $equipment->contract=$data['contract'];
        $in_service = $request->has('in_service');
        $equipment->in_service = $in_service;
        $equipment->save();
        session()->flash('success', 'Equipment updated successfully');
        return back();
    }

    public function show(Equipment $equipment)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $id=$equipment->id;
        $articles=Article::AvailableSpares($id);
        return view('equipments.show',compact('equipment','articles'));
    }

    public function createSpare(Equipment $equipment,Request $request)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
            $this->validate($request,['article'=>'required']);
            $data=$request->all();
            $av_articles=Article::AvailableSpares($equipment->id);
            $found=0;
            foreach ($av_articles as $article)
            {
                if($article->id==$data['article'])
                {
                    $found=1;
                    break;
                }
            }
            if($found==0)
                return back();

            $spare=new Spare();
            $spare->article_id=$data['article'];
            $spare->equipment_id=$equipment->id;
            $spare->save();
            session()->flash('success_article','Article added successfully');
            session()->flash('tab','spares');
            return back();
    }

    public function stocksArticle($id_article)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $stocks=Stock::StocksArticle($id_article);
        return new JsonResponse(['data'=>$stocks]);
    }

    public function destroySpare($id)
    {
        if (!(Auth::user()->role == 'super_admin' || Auth::user()->role == 'maintenance_manager'))
            return back();
        $spare=Spare::find($id);
        $spare->delete();
        session()->flash('success_article','Article deleted successfully');
        session()->flash('tab','spares');
        return back();
    }


}
