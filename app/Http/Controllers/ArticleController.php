<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function GetArticlesByCategory(Request $request){
        $articles = DB::table('articles')
        ->join('categories', 'categories.id', '=', 'articles.category_id')
        ->select('articles.id','articles.title', 'articles.description','categories.title as category','articles.price')
        ->where('categories.title', $request->category)
        ->get();

        return response($articles, 201);
    }

    public function GetArticles(){
        $articles = DB::table('articles')
        ->join('categories', 'categories.id', '=', 'articles.category_id')
        ->select('articles.id','articles.title', 'articles.description','categories.title as category','articles.price')
        ->get();
        return response($articles, 201);
    }

    public function FindArticle(Request $request){
       

        if($request->category == "all"){
            $articles = DB::table('articles')->join('categories', 'categories.id', '=', 'articles.category_id')
            ->select('articles.id','articles.title', 'articles.description','categories.title as category','articles.price')->orWhere('articles.title', 'like', '%'.$request->input.'%')->get();
        } else {
            $articles = DB::table('articles')->join('categories', 'categories.id', '=', 'articles.category_id')
            ->select('articles.id','articles.title', 'articles.description','categories.title as category','articles.price')->where('categories.title', $request->category)->where('articles.title', 'like', '%'.$request->input.'%')->get();
        }
        
        return response($articles, 201);
    }
}
