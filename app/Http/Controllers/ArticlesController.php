<?php

namespace App\Http\Controllers;

use App\Article;
use App\Cost;
use App\Provider;
use App\Purpose;
use App\Replacement_article;
use App\Suppliers_articles;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ArticlesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        return Article::Ajax();
        $this->authorize('index',Article::class);
//        $articles = Article::all();
        return view('articles.index');
    }

    public function create()
    {
        $this->authorize('create',Article::class);
        $manufacturers = Provider::select('id', 'code')->where('type', 'manufacturer')->get();
        return view('articles.create', compact('manufacturers'));
    }

    public function store(Request $request)
    {
        $this->authorize('create',Article::class);
        $this->validate($request, ['code' => 'required|unique:articles,code',
            'description' => 'required',
            'model' => 'required',
            'supply_point'=>'required|numeric',
            'manufacturer'=>'required',
            'added_in' => 'nullable|date']);
        $data = $request->all();
//        $manufacturer=Provider::select('id')->where('type','manufacturer')->where('id',$data['manufacturer'])->get();
        $manufacturer=Provider::select('id')->whereTypeAndId('manufacturer',$data['manufacturer'])->get();
        if($manufacturer->count()>0) {
            $article = new Article();
            $article->code = $data['code'];
            $article->description = $data['description'];
            $article->weight = $data['weight'];
            $article->model = $data['model'];
            $article->volume = $data['volume'];
            $article->added_in = $data['added_in'];
            $article->manufacturer_id = $data['manufacturer'];
            $article->supply_point=$data['supply_point'];
            $article->save();
            session()->flash('success', 'Article added successfully');
            return redirect('articles/create');
        }
        return back();
    }

    public function edit(Article $article)
    {
        $this->authorize('update',$article);
        $manufacturers = Provider::select('id', 'code')->where('type', 'manufacturer')->get();
        return view('articles.edit', compact('manufacturers', 'article'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update',$article);
        $this->validate($request, ['code' => 'required|unique:articles,code,' . $article->id,
            'description' => 'required',
            'model' => 'required',
            'supply_point'=>'required|numeric',
            'manufacturer'=>'required',
            'added_in' => 'nullable|date']);
        $data = $request->all();
        $manufacturer=Provider::select('id')->whereTypeAndId('manufacturer',$data['manufacturer'])->get();
        if($manufacturer->count()>0) {
            $article->code = $data['code'];
            $article->description = $data['description'];
            $article->weight = $data['weight'];
            $article->model = $data['model'];
            $article->volume = $data['volume'];
            $article->added_in = $data['added_in'];
            $article->manufacturer_id = $data['manufacturer'];
            $article->supply_point=$data['supply_point'];

            $article->save();
            session()->flash('success', 'Article updated successfully');
            return redirect('articles/' . $article->id . '/edit');
        }
        return back();
    }


    public function add_supplier(Request $request, Article $article)
    {
        $this->authorize('update',$article);
        $supplier = new Suppliers_articles();
        $supplier->article_id = $article->id;
        $supplier->supplier_id = $request->supplier;
        $supplier->save();
        session()->flash('success_supplier', 'Supplier added Successfully');
        session()->flash('tab', 'suppliers');
        return redirect('articles/' . $article->id);
    }

    public function destroy_supplier(Suppliers_articles $suppliers_articles)
    {
        $this->authorize('update',$suppliers_articles->article);
        $id = $suppliers_articles->article->id;
        $suppliers_articles->delete();
        session()->flash('success_supplier', 'Supplier deleted Successfully');
        session()->flash('tab', 'suppliers');
        return redirect('articles/' . $id);
    }

    public function show(Article $article)
    {
        $this->authorize('view',$article);
        $id = $article->id;
        $suppliers = Provider::select('id', 'code')->
        whereRaw("providers.id not in (select supplier_id from suppliers_articles where article_id=$id) and type='supplier' ")
            ->get();
        $replacements_list = Article::AvailableArticles($id);
        $this->list = $replacements_list;
        return view('articles.show', compact('article', 'suppliers', 'replacements_list'));
    }

    public function replace(Request $request, Article $article)
    {
        $this->authorize('update',$article);
        $data = $request->all();
        $isavailable = Article::IsavailableArticle($article->id, $data['article']);
        if ($isavailable) {
            $replacement = new Replacement_article();
            $replacement->article_id = $article->id;
            $replacement->replacement_id = $data['article'];
            $replacement->save();
            session()->flash('success_replace', 'The article was successfully replaced');
            session()->flash('tab', 'replacements');
            return redirect('articles/' . $article->id);
        }
        return back();
    }

    public function remove_replace(Replacement_article $replacement_article)
    {
        $this->authorize('update',$replacement_article->article);
        $id_article = $replacement_article->article->id;
        $replacement_article->delete();
        session()->flash('success_replace', 'Replacement has been deleted Successfully');
        session()->flash('tab', 'replacements');
        return redirect('articles/' . $id_article);
    }

//    public function showmore(Article $article)
//    {
//        return view('articles.showmore', compact('article'));
//    }

    public function createCost(Article $article)
    {
        $this->authorize('update',$article);
        return view('articles.cost.create', compact('article'));
    }

    public function storeCost(Request $request, Article $article)
    {
        $this->authorize('update',$article);
        $this->validate($request, ['date' => 'date|required',
            'cost' => 'required|numeric', 'qte' => 'required|integer']);
        $data=$request->all();
        $cost=new Cost();
        $cost->date=$data['date'];
        $cost->qte=$data['qte'];
        $cost->cost=$data['cost'];
        $cost->article_id=$article->id;
        $cost->save();
        session()->flash('success', 'Cost added Successfully');
        session()->flash('tab','costs');
        return back();
    }

    public function destroyCost(Cost $cost)
    {
        $this->authorize('update',$cost->article);
        $cost->delete();
        session()->flash('success_cost', 'Cost deleted Successfully');
        session()->flash('tab', 'costs');
        return back();
    }

    public function storePurposes(Request $request,Article $article)
    {
        $this->authorize('update',$article);
        session()->flash('tab', 'purposes');
        $this->validate($request,['usage'=>'required']);
        $data= $request->all();
        $purpose=new Purpose();
        $purpose->article_id=$article->id;
        $purpose->usage_note=$data['usage'];
        $purpose->save();
        session()->flash('success_purposes', 'Usage note added  Successfully');
        return back();
    }

    public function destroyPurpose(Purpose $purpose)
    {
        $this->authorize('update',$purpose->article);
        $purpose->delete();
        session()->flash('success_purposes', 'Purpose usage deleted Successfully');
        session()->flash('tab', 'purposes');
        return back();
    }

    public function update_cost(Request $request,Cost $cost)
    {
        $this->authorize('update',$cost->article);
        $this->validate($request,['qte'=>'required|numeric']);
        $cost->qte=$request->qte;
        $cost->save();
        session()->flash('success_cost', 'Quantity updated Successfully');
        session()->flash('tab', 'costs');
        return back();
    }

}
