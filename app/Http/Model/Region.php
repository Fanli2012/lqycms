<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use App\Common\Token;

class Region extends BaseModel
{
    //地区
    
    protected $table      = 'region';
    public    $timestamps = false;
    
    public static function getRegionName($id)
    {
        if(empty($id)){return '';}
        
        $res = self::where('id', $id)->value('name');
        if (!empty($res))
        {
            return $res;
        }

        return '';
    }
    
    public static function getList($parent_id=86)
    {
        return self::where('parent_id', $parent_id)->get()->toArray();
    }
    
    public static function getOne($id)
    {
        $res = self::where('id', $id)->first()->toArray();
        if (!empty($res))
        {
            return $res;
        }
        
        return false;
    }
}