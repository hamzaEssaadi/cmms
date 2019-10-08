<?php

namespace App\Http\Controllers;

use App\Drawing;
use App\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DrawingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Equipment $equipment)
    {
        return view('equipments.drawing.index', compact('equipment'));
    }

    public function create(Equipment $equipment)
    {
        return view('equipments.drawing.create', compact('equipment'));
    }

    public function show(Equipment $equipment)
    {
        return view('equipments.drawing.drawing', compact('equipment'));
    }

    public function store(Request $request, Equipment $equipment)
    {
        $this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'image' => 'image|required'
        ]);
        $data = $request->all();
        $drawing = new Drawing();
        $drawing->title = $data['title'];
        $drawing->type = $data['type'];
        $drawing->equipment_id = $equipment->id;
        if ($request->hasFile('image')) {
            $name_image = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('drawings/equipments'), $name_image);
            $drawing->path = $name_image;
        }
        $drawing->save();
        session()->flash('success', 'Technical drawing added successfully');
        return back();
    }

    public function destroy(Drawing $drawing)
    {
        if (File::exists(public_path('drawings/equipments') . '/'.$drawing->path)) {
            File::delete(public_path('drawings/equipments') . '/'.$drawing->path);
        }
        $drawing->delete();
        session()->flash('success','Technical drawing deleted successfully');
        return back();
    }
}
