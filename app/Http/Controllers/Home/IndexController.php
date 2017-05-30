<?php
namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home\CommonController;
use App\Http\Model\Article;
use App\Http\Model\Arctype;
use Illuminate\Support\Facades\DB;

class IndexController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
	public function index()
	{
		$user = DB::table('article')->where('id', '1')->first();
		echo $user->title;
		
		//$Article = Article::find(1)->arctype;
		//$Article = Article::find(1);
		//$Article = Arctype::find(1)->article()->get()->toArray();
		
		//$comment = Article::find(1)->arctype()->first()->toArray();
		//echo $comment->arctype->typename;
		//print_r($comment);
		
		//dd($comment);
	}
	
	public function page404()
	{
		return view('home.404');
	}
}
