<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Sysconfig extends Model
{
	//系统参数配置
	
    protected $table = 'sysconfig';
	public $timestamps = false;
	
	/**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = [];
}
