<?php
namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use App\Common\Token;
use Cache;

class Region extends BaseModel
{
    //地区
    
    protected $table      = 'region';
    public    $timestamps = false;
    
    public static function getRegionName($id)
    {
        $res = self::where('id', $id)->value('name');
        if (!empty($res))
        {
            return $res;
        }

        return false;
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