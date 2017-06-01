<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Friendlink extends Model
{
	//友情链接
	
	protected $table = 'friendlink';
    public $timestamps = false;
	protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	
}
