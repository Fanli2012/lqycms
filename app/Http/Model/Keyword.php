<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
	//内链关键词
	
	protected $table = 'keyword';
    public $timestamps = false;
	protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	
}
