<?php

namespace App\Http\Controllers;

use App\Article;
use App\Location;
use App\Stock;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function create(Article $article)
    {
        $id = $article->id;
        $locations = Location::AvailableLocations($id);
        return view('articles.stocks.create', compact('article', 'locations'));
    }

    public function store(Request $request, Article $article)
    {
        $this->validate($request, [
            'site' => 'required',
            'qte' => 'required|integer',
            'location' => 'required'
        ]);

        $data = $request->all();
        if(Location::CheckLocation($article->id,$data['location'])) {
            $stock = new Stock();
            $stock->qte = $data['qte'];
            $stock->location_id = $data['location'];
            $stock->site = $data['site'];
            $stock->article_id = $article->id;
            $stock->save();
            session()->flash('success', 'Stock added successfully');
            session()->flash('tab', 'stocks');
            return redirect('stocks/' . $article->id);
        }
        return "wrong location";
        return back();
    }


    public function destroy(Stock $stock)
    {
        if($stock->commands->count()==0) {
            $id = $stock->article->id;
            $stock->delete();
            session()->flash('success_stock', 'Stock deleted successfully');
            session()->flash('tab', 'stocks');
            return redirect('articles/' . $id);
        }
        session()->flash('tab', 'stocks');
        return back();
    }

    public function update(Request $request ,Stock $stock)
    {
        $this->validate($request, ['qte'=>'required|numeric']);
        $data =$request->all();
        $stock->qte=$data['qte'];
        $stock->save();
        session()->flash('success_stock', 'Quantity updated successfully');
        session()->flash('tab', 'stocks');
        return back();

    }

}
