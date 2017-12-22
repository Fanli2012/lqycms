<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Kuaidi extends Model
{
    //轮播图
    
	protected $table = 'kuaidi';
    public $timestamps = false;
	protected $guarded = []; //$guarded包含你不想被赋值的字段数组。
	
    //获取是否显示文字：0显示,1不显示
    public static function getStatusText($where)
    {
        $res = '';
        if($where['status'] === 0)
        {
            $res = '显示';
        }
        elseif($where['status'] === 1)
        {
            $res = '不显示';
        }
        
        return $res;
    }
}