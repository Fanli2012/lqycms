<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	//单页模型
	
	protected $table = 'page';
    public $timestamps = false;
	protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	
}
