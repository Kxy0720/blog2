<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $data = Article::latest()->paginate(5);

        return view('articles.index', [
            'articles'=> $data
        ]);
    }

    public function detail($id)
    {
        $data = Article::find($id);

        return view('articles.detail', [
            'article'=> $data
        ]);
    }

    public function add()
    {
        $data = [
            ["id"=> 1, "name"=> "News"],
            ["id"=> 2, "name"=> "Tech"],
        ];

        return view ('articles.add', [
            'categories'=> $data
        ]);
    }

    public function create()
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);
        
        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $article = new Article;
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();
        return redirect('/articles');
    }

    public function delete($id)
    {
        $article = Article::find($id);
        $article->delete();

        return redirect ('/articles')->with ('info', 'Article deleted');
    }

    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $data = [
            "id" => $article->id,
            "title" => $article->title,
            "body" => $article->body,
            "category_id" => $article->category_id,
        ];

        $categories = [
            ["id" => 1, "name" => "News"],
            ["id" => 2, "name" => "Tech"],
        ];

        return view('articles.edit', compact('data', 'categories'));
    }

    public function update($id)
    {
        $validator = validator(request()->all(), [
            'title' => 'required',
            'body' => 'required',
            'category_id' => 'required',
        ]);
        
        if($validator->fails()) {
            return back()->withErrors($validator);
        }
        
        $article = Article::findOrFail($id);
        $article->title = request()->title;
        $article->body = request()->body;
        $article->category_id = request()->category_id;
        $article->save();
        
        return redirect('/articles')->with('success', 'Article updated successfully!');
    }

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'detail']);
    }
}

//return view ('articles.edit', [
    //'article'=> $data
//]);

//$category = Category::where('status', '0')->get();
//$data = Article::find($id);
//return view ('articles.edit', ['article' => $data], compact('data'));