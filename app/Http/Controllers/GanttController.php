<?php

namespace App\Http\Controllers;

use App\Link;
use App\Task;
use Illuminate\Http\Request;


class GanttController extends Controller
{
    public function get()
    {
        $tasks=new Task();
        $links=new Link();
        return response()->json([
            'data'=>$tasks->all(),
            'links'=>$links->all()
        ]);
    }
}
