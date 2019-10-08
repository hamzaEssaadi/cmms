<?php

namespace App\Http\Controllers;

use App\Article;
use App\Command;
use App\Employee;
use App\Location;
use App\Stock;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommandsController extends Controller
{
    public function index(Article $article)
    {
        $this->authorize('index',Article::class);
        $commands=Command::select('id','date','status')->where('status','pending')->where('article_id',$article->id)->get();
        foreach ($commands as $command)
        {
            $date=Carbon::parse($command->date);
            if(!$date->isFuture() or $date->isToday())
            {
                $command->status='valid';
                $command->save();
            }
        }
        return view('articles.commands.index', compact('article'));
    }

    public function create(Article $article)
    {
        $this->authorize('update',$article);
        $locations = Location::select('id', 'code')->get();
        $employees = Employee::select('id', 'name')->get();
        return view('articles.commands.create', compact('article', 'locations', 'employees'));
    }

    public function store(Request $request, Article $article)
    {
        $this->authorize('update',$article);
        $this->validate($request, [
            'delivered_to' => 'required',
            'delivered_from' => 'required',
            'quantity_released' => 'required',
            'cost' => 'required|numeric',
            'date' => 'required|date',
            'reason' => 'required',
            'location' => 'required'
        ]);
        $data=$request->all();
        $employee=Employee::find($data['delivered_to']);
        if($employee==null)
            return back();
        $location=Location::find($data['location']);
        if($location==null)
            return back();
        $iscontainedStock=$article->ContainStock($data['delivered_from']);
        $stock=Stock::find($data['delivered_from']);
        if ((integer)$request->quantity_released > (integer)$stock->qte)
            return back();
        if(!$iscontainedStock)
            return back();
        $stock->qte=(integer)($stock->qte-$request->quantity_released);
        $command=new Command();
        $command->employee_id=$data['delivered_to'];
        $command->stock_id=$data['delivered_from'];
        $command->qte_out=$data['quantity_released'];
        $command->cost=$data['cost'];
        $command->date=$data['date'];
        $command->reason=$data['reason'];
        $command->location_id=$data['location'];
        $command->article_id=$article->id;
        $date=Carbon::parse($data['date']);
        $command->status=!$date->isFuture() || $date->equalTo(Carbon::now())?'valid':'pending';
        $command->save();
        $stock->save();
        session()->flash('success','Command added successfully');
        return back();
    }


    public function qteStock(Stock $stock)
    {
        return new JsonResponse(['qte' => (float)$stock->qte]);
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function cancelCommand(Command $command)
    {
        $this->authorize('update',$command->article);
        $stock=$command->stock;
        $stock->qte=(integer)($stock->qte+$command->qte_out);
        $command->delete();
        $stock->save();
        session()->flash('success','Command canceled successfully');
        return back();
    }

    public function all()
    {
        $this->authorize('index',Article::class);
        $commands=Command::select('id','date','status')->where('status','pending')->get();
        foreach ($commands as $command)
        {
            $date=Carbon::parse($command->date);
            if(!$date->isFuture() or $date->isToday())
            {
                $command->status='valid';
                $command->save();
            }
        }
        return view('articles.commands.all');

    }
}
