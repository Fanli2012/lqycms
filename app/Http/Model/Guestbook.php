<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Guestbook extends Model
{
	//在线留言
	
	protected $table = 'guestbook';
    public $timestamps = false;
	protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	
}
